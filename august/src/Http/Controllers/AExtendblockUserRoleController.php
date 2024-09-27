<?php 

namespace Package\August\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Package\August\Models\AExtendblockUserRole;

class AExtendblockUserRoleController extends BaseController {
    const LIMIT = 5;

    public static function getList($arParams = array()) {
        $offset = isset($arParams['OFFSET']) ? $arParams['OFFSET'] : 0;
        $limit = isset($arParams['LIMIT']) ? $arParams['LIMIT'] : 5;

        $res = AExtendblockUserRole::offset($offset)->limit($limit)->get();

        return $res;
    }

    public function index(Request $request) {
        $currentPage = $request->input('page', 1);

        $totalRoles = AExtendblockUserRole::count();
        $offset = ($currentPage - 1) * self::LIMIT;
        
        // $arResults['ITEMS'] = AExtendblockUserRole::offset($offset)->limit(self::LIMIT)->get();

        $arResults['ITEMS'] = self::getList(array("OFFSET" => $offset));
        $arResults['PAGE'] = $currentPage;
        $arResults['TOTAL_PAGES'] = ceil($totalRoles / self::LIMIT);
        
        return view('August::userrole.index', ['arResults' => $arResults]);
    }

    public function add() {
        $arParams = array(
            'ID' => 0
        );
        
        return view('August::userrole.add', ['arParams' => $arParams]);
    }

    public function copy(string $roleId) {
        $role = AExtendblockUserRole::where('id', $roleId)->first();

        $arParams = array(
            'ID' => 0,
            'ROLE' => $role,
        );

        return view('August::userrole.add', ['arParams' => $arParams]);
    }

    public function edit(string $roleId) {
        $role = AExtendblockUserRole::where('id', $roleId)->first();

        $arParams = array(
            'ID' => $roleId,
            'ROLE' => $role,
        );

        return view('August::userrole.add', ['arParams' => $arParams]);
    }

    public function store(Request $request) {
        $inputs = $request->input();

        if(isset($inputs['id']) && (intval($inputs['id']) == 0)) {
            try {
                $roleId = AExtendblockUserRole::create(array(
                    "code" => $inputs['code'],
                    "name" => $inputs['name']
                ))->id;

                if (isset($inputs['btn_action']) && ($inputs['btn_action'] == 'apply')) {
                    return redirect()->route('august.user.role.edit', ['id_role' => $roleId]);
                } else {
                    return redirect()->route('august.user.role.index');
                }
            } catch(\Illuminate\Database\QueryException $exception) {
                return back()->withErrors(['exception' => trans('August::messages.exception')]);
            }
        } else {
            $role = AExtendblockUserRole::where('id', $inputs['id'])->first();
            $role->code = $inputs['code'];
            $role->name = $inputs['name'];
            $role->save();

            if (isset($inputs['btn_action']) && ($inputs['btn_action'] == 'apply')) {
                return redirect()->route('august.user.role.edit', ['id_role' => $inputs['id']]);
            } else {
                return redirect()->route('august.user.role.index');
            }
        }
    }

    public function delete($roleId) {
        $role = AExtendblockUserRole::where('id', $roleId)->first();

        $result = $role->delete();
        if($result) {
            return redirect()->back();
        }
    }
}