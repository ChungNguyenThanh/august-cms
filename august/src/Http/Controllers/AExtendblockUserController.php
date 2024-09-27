<?php 

namespace Package\August\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Package\August\Models\AExtendblockFile;
use Package\August\Models\AExtendblockUserMeta;
use Package\August\Models\AExtendblockUserRole;
use Package\August\Models\AExtendblockUserRoleRelation;
use Package\August\Models\AExtendblockUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AExtendblockUserController extends BaseController {
    const LIMIT = 5;

    public static function getList($arParams = array()) {
        $offset = isset($arParams['OFFSET']) ? $arParams['OFFSET'] : 0;
        $limit = isset($arParams['LIMIT']) ? $arParams['LIMIT'] : 5;

        $users = AExtendblockUsers::offset($offset)->limit($limit)->get();
        $res = [];

        foreach($users as $user) {
            $user_meta = AExtendblockUserMeta::where('user_id', $user->id)->first();

            if (isset($user_meta) && !empty($user_meta->photo)) {
                $file = AExtendblockFile::where('id', $user_meta->photo)->first();
            }

            $data = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'last_name' => $user_meta ? $user_meta->last_name : null,
                'first_name' => $user_meta ? $user_meta->first_name : null,
                'photo' => null,
            ];

            if (isset($file) && $file) {
                $data['photo'] = !empty($user_meta->photo) ? $file->path : null;
            }

            $res[] = (object) $data;
        }

        return $res;
    }

    public function index(Request $request) {
        $currentPage = $request->input('page', 1);
        $totalUsers = AExtendblockUsers::count();
        $offset = ($currentPage - 1) * self::LIMIT;
        $arResults = [];
        $arResults['ITEMS'] = self::getList(array("OFFSET" => $offset));
        $arResults['PAGE'] = $currentPage;
        $arResults['TOTAL_PAGES'] = ceil($totalUsers / self::LIMIT);

        return view('August::users.index', ['arResults' => $arResults]);
    }
    
    public function add() {
        $arParams = array(
            'ID' => 0,
            'ROLE' => AExtendblockUserRole::get(),
        );
        return view('August::users.add', ['arParams' => $arParams]);
    }

    public function edit(string $userId) {
        $user = AExtendblockUsers::where('id', $userId)->first();
        $user_meta = AExtendblockUserMeta::where('user_id', $userId)->first();
        
        $arParams = array(
            'ID' => $userId,
            'USER' => $user,
            'USER_META' => $user_meta,
            'ROLE' => AExtendblockUserRole::get(),
            'RELATION' => AExtendblockUserRoleRelation::where('user_id', $userId)->get(),
        );

        if(isset($user_meta) && !empty($user_meta->photo)) {
            $arParams['USER_FILE'] = AExtendblockFile::where('id', $user_meta->photo)->first();
        }

        return view('August::users.add', ['arParams' => $arParams]);
    }

    public function copy(string $userId) {
        $user = AExtendblockUsers::where('id', $userId)->first();
        $user_meta = AExtendblockUserMeta::where('user_id', $userId)->first();
        
        $arParams = array(
            'ID' => 0,
            'USER' => $user,
            'USER_META' => $user_meta
        );
        return view('August::users.add', ['arParams' => $arParams]);
    }

    public function store(Request $request) {
        $messages = [
            'name.required' => trans('August::validation.users_name.required'),
            'email.required' => trans('August::validation.users_email.required'),
            'email.email' => trans('August::validation.users_email.fomat'),
            'password.required' => trans('August::validation.users_password.required'),
        ];

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'email' => 'email',
        ], $messages);

        $inputs = $request->input();
        // dd($request->all());
        $year = Carbon::now()->year;
        $month = Carbon::now()->format('m');
        $path = "$year/$month";

        if(isset($inputs['id']) && (intval($inputs['id']) == 0)) {
            $request->validate([
                'password' => 'required',
            ], $messages);

            $users = AExtendblockUsers::where('email', $inputs['email'])->first();
            if(!empty($users)) {
                return back()->withErrors(['email.exist' => trans('August::validation.users_email.exist')]);
            } else {
                try {
                    $userId = AExtendblockUsers::create(array(
                        "name" => $inputs['name'],
                        "email" => $inputs['email'],
                        "password" => Hash::make($inputs['password']),
                    ))->id;

                    if ($userId) {
                        $fileId = null;
                        if($request->hasFile('photo')) {
                            $file = $request->file('photo');

                            $fileStore = time().'.'.$file->getClientOriginalExtension();
                            $path_db = $file->storeAs($path, $fileStore, 'public');

                            $inputs['name'] = $file->getClientOriginalName();

                            $fileId = AExtendblockFile::create(array(
                                "name" => $inputs['name'],
                                "path" => $path_db,
                            ))->id;
                        }

                        AExtendblockUserMeta::create(array(
                            "first_name" => $inputs['first_name'],
                            "last_name" => $inputs['last_name'],
                            "gender" => !empty($inputs['gender']) ? $inputs['gender'] : 0,
                            "birthday" => $inputs['birthday'],
                            "phone" => $inputs['phone'],
                            "photo" => $fileId,
                            "user_id" => $userId
                        ));

                        if(isset($inputs['roles']) && !empty($inputs['roles'])) {
                            foreach($inputs['roles'] as $role) {
                                AExtendblockUserRoleRelation::create(array(
                                    "user_id" => $userId,
                                    "role_id" => $role,
                                ));
                            }
                        }
                    }

                    if (isset($inputs['btn_action']) && ($inputs['btn_action'] == 'apply')) {
                        return redirect()->route('august.users.edit', ['id_user' => $userId]);
                    } else {
                        return redirect()->route('august.users.index');
                    }
                } catch (\Illuminate\Database\QueryException $exception) {
                    return back()->withErrors(['exception' => trans('August::messages.exception')]);
                }
            }
        } else {
            $user = AExtendblockUsers::where('id', $inputs['id'])->first();
            $user->name = $inputs['name'];
            $user->email = $inputs['email'];
            if(isset($inputs['password']) && !empty($inputs['password'])) {
                $user->password = Hash::make($inputs['password']);
            }

            $user->save();

            if(isset($inputs['roles']) && !empty($inputs['roles'])) {
                AExtendblockUserRoleRelation::where('user_id', $inputs['id'])->delete();

                foreach($inputs['roles'] as $role) {
                    AExtendblockUserRoleRelation::create(array(
                        "user_id" => $inputs['id'],
                        "role_id" => $role,
                    ));
                }
            }

            $user_meta = AExtendblockUserMeta::where('user_id', $user->id)->first();
            if ($user_meta) {
                $user_meta->first_name = $inputs['first_name'];
                $user_meta->last_name = $inputs['last_name'];
                $user_meta->gender = !empty($inputs['gender']) ? $inputs['gender'] : 0;
                $user_meta->birthday = $inputs['birthday'];
                $user_meta->phone = $inputs['phone'];
                $user_meta->save();

                if($request->hasFile('photo')) {
                    $file = $request->file('photo');
    
                    $fileStore = time().'.'.$file->getClientOriginalExtension();
                    $path_db = $file->storeAs($path, $fileStore, 'public');
    
                    $inputs['name'] = $file->getClientOriginalName();
    
                    $fileNew = AExtendblockFile::where('id', $user_meta->photo)->first();
                    if ($fileNew) {
                        $fileNew->name = $inputs['name'];
                        $fileNew->path = $path_db;
                        $fileNew->save();
                    } else {
                        $fileId = AExtendblockFile::create(array(
                            "name" => $inputs['name'],
                            "path" => $path_db,
                        ))->id;

                        $user_meta->photo = $fileId;
                        $user_meta->save();
                    }
                }
            } else {
                if($request->hasFile('photo')) {
                    $file = $request->file('photo');

                    $fileStore = time().'.'.$file->getClientOriginalExtension();
                    $path_db = $file->storeAs($path, $fileStore, 'public');

                    $inputs['name'] = $file->getClientOriginalName();

                    $fileId = AExtendblockFile::create(array(
                        "name" => $inputs['name'],
                        "path" => $path_db,
                    ))->id;
                }

                AExtendblockUserMeta::create(array(
                    "first_name" => isset($inputs['first_name']) ? $inputs['first_name'] : null,
                    "last_name" => isset($inputs['last_name']) ? $inputs['last_name'] : null,
                    "gender" => isset($inputs['gender']) ? $inputs['gender'] : 1,
                    "birthday" => isset($inputs['birthday']) ? $inputs['birthday'] : null,
                    "phone" => isset($inputs['phone']) ? $inputs['phone'] : null,
                    "photo" => isset($fileId) ? $fileId : null,
                    "user_id" => $user->id
                ));
            }

            if (isset($inputs['btn_action']) && ($inputs['btn_action'] == 'apply')) {
                return redirect()->route('august.users.edit', ['id_user' => $inputs['id']]);
            } else {
                return redirect()->route('august.users.index');
            }
        }
    }

    public function searchUsers(Request $request) {
        $name = $request->name;
        $users = AExtendblockUsers::where('name', 'LIKE', '%'.$name.'%')->get();

        $arResults = array();

        foreach($users as $user) {
            $user_meta = AExtendblockUserMeta::where('user_id', $user->id)->first();

            if(isset($user_meta) && !empty($user_meta->photo)) {
                $file = AExtendblockFile::where('id', $user_meta->photo)->first();
            }

            $data = (object)[
                'id' => $user->id,
                'name' => $user->name,
                'photo' => !empty($user_meta->photo) ? $file->path : null,
            ];

            $arResults['USERS'][] = $data;
        }

        return view('August::users.search', ['arResults' => $arResults]);
    }

    public function delete($userId) {
        $user = AExtendblockUsers::findOrFail($userId);

        $result = $user->delete();
        if($result) {
            return redirect()->back();
        }
    }

    public function preview (string $userId) {
        $user = AExtendblockUsers::where('id', $userId)->first();
        $user_meta = AExtendblockUserMeta::where('user_id', $userId)->first();
        
        $arParams = array(
            'ID' => $userId,
            'USER' => $user,
            'USER_META' => $user_meta,
            'ROLE' => AExtendblockUserRole::get(),
            'RELATION' => AExtendblockUserRoleRelation::where('user_id', $userId)->get(),
        );

        if(isset($user_meta) && !empty($user_meta->photo)) {
            $arParams['USER_FILE'] = AExtendblockFile::where('id', $user_meta->photo)->first();
        }

        return view('August::users.preview', ['arParams' => $arParams]);
    }

    public static function getCurrentUser() {
        $userId = Auth::id();

        if (!$userId) {
            return;
        }

        $users = \DB::table('users')
            ->select("users.id", "users.name", "a_extendblock_user_meta.photo", "a_extendblock_user_role.code as role")
            ->leftJoin('a_extendblock_user_meta', 'users.id', '=', 'a_extendblock_user_meta.user_id')
            ->leftJoin('a_extendblock_user_role_relation', 'users.id', '=', 'a_extendblock_user_role_relation.user_id')
            ->leftJoin('a_extendblock_user_role', 'a_extendblock_user_role.id', '=', 'a_extendblock_user_role_relation.role_id')
            ->where('users.id', $userId)
            ->first();

        if (isset($users) && !empty($users->photo)) {
            $avatar = AExtendblockFile::where('id', $users->photo)->first();
            if ($avatar) {
                $users->avatar = asset('storage/' . $avatar->path);
            } else {
                $users->avatar = "/assets-august/images/users/avatar-1.jpg";
            }
        } else {
            $users->avatar = "/assets-august/images/users/avatar-1.jpg";
        }

        return $users;
    }
}