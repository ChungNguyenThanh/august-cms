<?php

namespace Package\August\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Package\August\Models\AExtendblockEntity;
use Package\August\Models\AExtendblockFile;
use Package\August\Models\AExtendblockUsers;

class AExtendblockFileController extends BaseController {
    const LIMIT = 5;

    public function index(Request $request) {
        $arResults = array();
        $arResults['ITEMS'] = array();
        $currentPage = $request->input('page', 1);

        $totalFiles = AExtendblockFile::count();
        $offset = ($currentPage - 1) * self::LIMIT;
        
        $files = AExtendblockFile::offset($offset)->limit(self::LIMIT)->get();

        $arUserID = array();

        $arResults['ITEMS'] = array();

        foreach ($files as $file) {
            $extension = pathinfo($file->name, PATHINFO_EXTENSION);

            $is_image = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);

            $data = (object)[
                "id" => $file->id,
                "name" => $file->name,
                "is_image" => $is_image,
                "path" => $file->path,
                "extension" => $file->extension,
                "author" => $file->author
            ];

            $arUserID[] = $file->author;

            $arResults['ITEMS'][] = $data;
        }


        // get list user
        $arUser = AExtendblockUsers::whereIn('id', $arUserID)->get();
        foreach ($arUser as $key => $value) {
            $arResults['USERS'][$value['id']] = array(
                'name' => $value->name
            );
        }

        // set author name
        foreach ($arResults['ITEMS'] as $key => $value) {
            if (isset($arResults['USERS'][$value->author])) {
                $arResults['ITEMS'][$key]->author = $arResults['USERS'][$value->author]['name'];
            }
        }

        $arResults['PAGE'] = $currentPage;
        $arResults['TOTAL_PAGES'] = ceil($totalFiles / self::LIMIT);
        $arResults['TOTAL_ITEMS'] = $totalFiles;

        // dd($arResults);

        return view('August::file.index', ['arResults' => $arResults]);
    }

    public function add() {
        $arParams = array('ID' => 0);

        return view('August::file.add', ['arParams' => $arParams]);
    }

    public function edit(string $fileId) {
        $file = AExtendblockFile::where('id', $fileId)->first();

        if($file) {
            $extension = pathinfo($file->name, PATHINFO_EXTENSION);

            $file->is_image = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
        }

        $arParams = array(
            'ID' => $fileId,
            'FILE' => $file,
        );
        // dd($arParams);
        return view('August::file.add', ['arParams' => $arParams]);
    }

    public function delete($fileId) {
        $file = AExtendblockFile::findOrFail($fileId);

        $result = $file->delete();

        if ($result) {
            return redirect()->back();
        }
    }

    public function store(Request $request) {
        $messages = [
            'file.required' => trans('August::validation.file.required'),
        ];

        $inputs = $request->input();
        $year = Carbon::now()->year;
        $month = Carbon::now()->format('m');
        $path = "$year/$month";

        if (isset($inputs['id']) && (intval($inputs['id']) == 0)) { 
            $request->validate([
                'file' => 'required',
            ], $messages);

            if ($request->hasFile('file')) {
                try {
                    $file = $request->file('file');

                    $fileStore = time().'.'.$file->getClientOriginalExtension();
                    $path_db = $file->storeAs($path, $fileStore, 'public');

                    $inputs['name'] = $file->getClientOriginalName();

                    $fileId = AExtendblockFile::create(array(
                        "name" => $inputs['name'],
                        "path" => $path_db,
                        "extension" => $inputs['extension'],
                        "author" => $inputs['author'],
                    ))->id;

                    if (isset($inputs['btn_action']) && ($inputs['btn_action'] == 'apply')) {
                        return redirect()->route('august.file.edit', ['id_file' => $fileId]);
                    } else {
                        return redirect()->route('august.file.index');
                    }
                } catch (\Illuminate\Database\QueryException $exception) {
                    return back()->withErrors(['exception' => trans('August::messages.exception')]);
                }
            }
        } else {
            $fileNew = AExtendblockFile::where('id', $inputs['id'])->first(); 
            $fileNew->extension = $inputs['extension'];
            $fileNew->author = $inputs['author'];
            if($request->hasFile('file')) { 
                $file = $request->file('file');

                $fileStore = time().'.'.$file->getClientOriginalExtension();
                $path_db = $file->storeAs($path, $fileStore, 'public');

                $inputs['name'] = $file->getClientOriginalName();

                $fileNew->name = $inputs['name'];
                $fileNew->path = $path_db;
            }
            $fileNew->save();

            if (isset($inputs['btn_action']) && ($inputs['btn_action'] == 'apply')) {
                return redirect()->route('august.file.edit', ['id_file' => $inputs['id']]);
            } else {
                return redirect()->route('august.file.index');
            }
        }
    }

    public function deleteImageField(Request $request) {
        $ablock = AExtendblockEntity::findOrFail($request->ablock_id);

        if($request->multiple == 'Y') {
            $table_field = $ablock->name . "_" . strtolower($request->field_name);

            if(Schema::hasTable($table_field)) {
                DB::table($table_field)->where('value', $request->id)->delete();
            }
        }else {
            DB::table($ablock->name)
            ->where(strtolower($request->field_name), $request->id)
            ->update([strtolower($request->field_name) => null]);
        }
    }

    public static function getPathById ($fileId) {
        $file = AExtendblockFile::findOrFail($fileId);
        if ($file) {
            return $file->path;
        }
    }
}