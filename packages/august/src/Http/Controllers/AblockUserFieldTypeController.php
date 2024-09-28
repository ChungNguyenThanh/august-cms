<?php

namespace Package\August\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Package\August\Models\AExtendblockUserFieldType;

class AblockUserFieldTypeController extends BaseController {

    public function index() {
        $arResults['ITEMS'] = AExtendblockUserFieldType::get();
        return view('August::ablockuserfieldtype.index', ['arResults' => $arResults]);
    }

    public function add() {
        $arParams = array(
            "ID" => 0,
        );
        return view('August::ablockuserfieldtype.add', ['arParams' => $arParams]);
    }

    public function edit($typeId) {
        $fieldType = AExtendblockUserFieldType::where('id',$typeId)->first();
        
        $arParams = array(
            "ID" => $fieldType->id,
            'USER_FIELD_TYPE' => $fieldType,
        );
        return view('August::ablockuserfieldtype.add', ['arParams' => $arParams]);
    }

    public function store(Request $request) {
        $messages = [
            'code.required' => trans('August::validation.code.required'),
            'user_field_type.required' => trans('August::validation.user_field_type.required'),
            'db_type.required' => trans('August::validation.db_type.required'),
            'accessori_type.required' => trans('August::validation.accessori_type.required'),
        ];

        $request->validate([
            'code' => 'required',
            'user_field_type' => 'required',
            'db_type' => 'required',
            'accessori_type' => 'required',
        ], $messages);

        $inputs = $request->input();

        if (!isset($inputs['id']) || (intval($inputs['id']) == 0)) {
            $userFieldType = AExtendblockUserFieldType::where('user_field_type',$inputs['user_field_type'])->first();

            if(!empty($userFieldType)) {
                return back()->withErrors(['user_field_type.exist' => trans('August::validation.user_field_type.exist')]);
            }else {
                try {
                    $typeId = AExtendblockUserFieldType::create(array(
                        "code" => $inputs['code'],
                        "user_field_type" => $inputs['user_field_type'],
                        "db_type" => $inputs['db_type'],
                        "accessori_type" => $inputs['accessori_type'],
                    ))->id;

                    if (isset($inputs['btn_action']) && ($inputs['btn_action'] == 'apply')) {
                        return redirect()->route('august.userfieldtype.edit', ['id_fieldtype' => $typeId]);
                    } else {
                        return redirect()->route('august.userfieldtype.index');
                    }
                } catch (\Illuminate\Database\QueryException $exception) {
                    return back()->withErrors(['exception' => $exception->getMessage()]);
                }
            }
        } else {
            $fieldType = AExtendblockUserFieldType::where('id', $inputs['id'])->first();
            $fieldType->code = $inputs['code'];
            $fieldType->user_field_type = $inputs['user_field_type'];
            $fieldType->db_type = $inputs['db_type'];
            $fieldType->accessori_type = $inputs['accessori_type'];
            $fieldType->save();

            if (isset($inputs['btn_action']) && ($inputs['btn_action'] == 'apply')) {
                return redirect()->route('august.userfieldtype.edit', ['id_fieldtype' => $inputs['id']]);
            } else {
                return redirect()->route('august.userfieldtype.index');
            }
        }
    }

    public function copy($typeId) {
        $fieldType = AExtendblockUserFieldType::where('id',$typeId)->first();
        
        $arParams = array(
            "ID" => $fieldType->id,
            'USER_FIELD_TYPE' => $fieldType,
        );
        return view('August::ablockuserfieldtype.add', ['arParams' => $arParams]);
    }

    public function delete($typeId) {
        $fieldType = AExtendblockUserFieldType::findOrFail($typeId);

        $result = $fieldType->delete();
        if($result) {
            return redirect()->route('august.userfieldtype.index');
        }
    }
}