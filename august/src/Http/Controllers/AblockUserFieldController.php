<?php

namespace Package\August\Http\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Package\August\Http\Controllers\UtilityController;
use Package\August\Models\AExtendblockEntity;
use Package\August\Models\AExtendblockUserField;
use Package\August\Models\AExtendblockUserFieldEnum;
use Package\August\Models\AExtendblockUserFieldLang;

class AblockUserFieldController extends BaseController {
    public function index($ablockId) {
        if (!UtilityController::checkAblockExists($ablockId)) {
            return view('August::ablock.not-found-ablock', ['arParams' => array('ABLOCK_ID' => $ablockId)]);
        }

        $arParams = array(
            "ABLOCK_ID" => $ablockId,
            'USER_FIELD_TYPE' => UtilityController::getUserFieldType(),
        );

        $arResults['ITEMS'] = AExtendblockUserField::where('entity_id', "A_BLOCK_".$ablockId)->orderBy('sort', 'asc')->get();

        // dd($arParams);
        // dd($arResults);

        return view('August::ablockuserfield.index', ['arParams' => $arParams, 'arResults' => $arResults]);
    }

    public function add($ablockId) {
        $arParams = array(
            "ABLOCK_ID" => $ablockId,
            "ABLOCK_CODE" => "A_BLOCK_".$ablockId,
            "ID" => 0,
            'USER_FIELD_TYPE' => UtilityController::getUserFieldType(),
            'ABLOCK' => AExtendblockEntity::get(),
        );
        return view('August::ablockuserfield.add', ['arParams' => $arParams]);
    }

    public function edit($ablockId, $fieldId) {
        $curLang = app()->getLocale();
        // check ablock exist
        $userField = AExtendblockUserField::where('id', $fieldId)->first();
        if(isset($userField->settings) && !empty($userField->settings)) {
            $link_to_ablock = json_decode($userField->settings);
            $field_id = AExtendblockUserField::where('entity_id', 'A_BLOCK_' . $link_to_ablock->link_to_ablock)->pluck('id');
            $fields = AExtendblockUserField::leftJoin('a_extendblock_user_field_lang','a_extendblock_user_field.id','=','a_extendblock_user_field_lang.user_field_id')
            ->whereIn('a_extendblock_user_field.id', $field_id)
            ->where('a_extendblock_user_field_lang.lang_id', $curLang)
            ->select('a_extendblock_user_field.field_name AS field_name',
                    'a_extendblock_user_field_lang.edit_form_label AS edit_form_label')
            ->get();
        }

        $arParams = array(
            "ABLOCK_ID" => $ablockId,
            "ABLOCK_CODE" => "A_BLOCK_".$ablockId,
            "ID" => $userField->id,
            'USER_FIELD_TYPE' => UtilityController::getUserFieldType(),
            "USER_FIELD" => $userField,
            'ABLOCK' => AExtendblockEntity::get(),
            "USER_FIELD_LANG" => AExtendblockUserFieldLang::where('user_field_id', $fieldId)->get(),
            "USER_FIELD_ENUM" => AExtendblockUserFieldEnum::where('user_field_id', $fieldId)->get(),
            "SETTINGS" => json_decode($userField->settings),
        );

        if(!empty($fields)) {
            $arParams['LIST_FIELD'] = $fields;
        }

        return view('August::ablockuserfield.add', ['arParams' => $arParams]);
    }

    public function copy($ablockId, $fieldId) {

        $userField = AExtendblockUserField::where('id', $fieldId)->first();

        $arParams = array(
            "ABLOCK_ID" => $ablockId,
            "ABLOCK_CODE" => "A_BLOCK_".$ablockId,
            "ID" => 0,
            'USER_FIELD_TYPE' => UtilityController::getUserFieldType(),
            "USER_FIELD" => $userField,
            "USER_FIELD_LANG" => AExtendblockUserFieldLang::where('user_field_id', $fieldId)->get()
        );

        return view('August::ablockuserfield.add', ['arParams' => $arParams]);
    }

    public function store(Request $request) {
        // dd($request->all());
        // validate
        $messages = [
            'field_name.required' => trans('August::validation.field_name.required'),
            'enum_settings.xml_id.*.required' =>trans('August::validation.enum_settings.required'),
            'enum_settings.value.*.required' =>trans('August::validation.enum_settings.required'),
            'enum_settings.sort.*.required' =>trans('August::validation.enum_settings.required'),
            'enum_settings.default.*.required' =>trans('August::validation.enum_settings.required'),
            'settings.link_to_ablock.required' => trans('August::validation.settings.link_to_ablock.required'),
        ];

        $request->validate([
            'field_name' => 'required',
        ], $messages);

        $inputs = $request->input();
        // dd($inputs);

        if($inputs['user_type_id'] == 'link_to_element') {
            if(empty($inputs['settings']['link_to_ablock'])) {
                $request->validate([
                    'settings.link_to_ablock' => 'required',
                ], $messages);
            }
        }

        if(!empty($inputs['user_type_id']) && $inputs['user_type_id'] == 'enum') {
            $request->validate([
                'enum_settings.xml_id.*' => 'required',
                'enum_settings.value.*' => 'required',
                'enum_settings.sort.*' => 'required'
            ], $messages);
        } else {
            if (isset($inputs['enum_settings'])) {
                unset($inputs['enum_settings']);
            }
        }

        // dd($inputs);


        if (!isset($inputs['id']) || (intval($inputs['id']) == 0)) {
            // check ablock exist
            $userField = AExtendblockUserField::where('field_name', $inputs['field_name'])->where('entity_id', $inputs['entity_id'])->first();

            if (!empty($userField)) {
                return back()->withErrors(['field_name.exist' => trans('August::validation.field_name.exist')]);
            } else {
                try {
                    $fieldId =  AExtendblockUserField::create(array(
                        "entity_id" => $inputs['entity_id'],
                        "field_name" => $inputs['field_name'],
                        "user_type_id" => $inputs['user_type_id'],
                        "sort" => $inputs['sort'],
                        "xml_id" => $inputs['xml_id'],
                        "show_filter" => $inputs['show_filter'],
                        "multiple" => $inputs['multiple'],
                        "mandatory" => $inputs['mandatory'],
                        "show_in_list" => $inputs['show_in_list'],
                        "edit_in_list" => $inputs['edit_in_list'],
                        "show_add_form" => $inputs['show_add_form'],
                        "show_edit_form" => $inputs['show_edit_form'],
                        "add_read_only_field" => $inputs['add_read_only_field'],
                        "edit_read_only_field" => $inputs['edit_read_only_field'],
                        "show_field_preview" => $inputs['show_field_preview'],
                        "is_searchable" => $inputs['is_searchable'],
                        "settings" => json_encode($inputs['settings']),
                    ))->id;

                    if (isset($inputs['lang'])) {
                        foreach ($inputs['lang'] as $key => $value) {
                            AExtendblockUserFieldLang::create(array(
                                "user_field_id" => $fieldId,
                                "lang_id" => $key,
                                "edit_form_label" => $value['edit_form_label'],
                                "list_column_label" => $value['list_column_label'],
                                "list_filter_label" => $value['list_filter_label'],
                                "error_message_label" => $value['error_message_label'],
                                "help_message_label" => $value['help_message_label'],
                            ));
                        }
                    }

                    // dd($inputs['enum_settings']);

                    if (isset($inputs['enum_settings'])) {
                        // dd($inputs['enum_settings']);
                        $indDef = isset($inputs['enum_settings']['default'][0]) ? $inputs['enum_settings']['default'][0] : 0;
                        
                        foreach ($inputs['enum_settings']['xml_id'] as $key => $xmlId) {
                            if (empty($inputs['enum_settings']['value'][$key]) || empty($inputs['enum_settings']['sort'][$key]) || empty($xmlId)) {
                                continue;
                            }

                            $def = ($inputs['enum_settings']['index'][$key] == $indDef) ? 1 : 0;

                            AExtendblockUserFieldEnum::create([
                                'user_field_id' => $fieldId,
                                'value' => $inputs['enum_settings']['value'][$key],
                                'sort' => $inputs['enum_settings']['sort'][$key],
                                'xml_id' => $xmlId,
                                'def' => $def,
                            ]);
                        }
                    }

                    $ablockId = AExtendblockEntity::findOrFail($inputs['ablock_id']);
                    $mapUserFieldType = UtilityController::mapUserFieldType($inputs['user_type_id']);
                    
                    if (!Schema::hasColumn($ablockId->table_name,$inputs['field_name'])) {
                        DB::statement("ALTER TABLE `{$ablockId->table_name}` ADD COLUMN `".strtolower($inputs['field_name'])."` {$mapUserFieldType} NULL");
                    }

                    if (!empty($inputs['multiple']) && ($inputs['multiple'] == 'Y')) {
                        $table_accessories = $ablockId->table_name.'_'.strtolower($inputs['field_name']);
                        $mapAccessoriesFieldType = UtilityController::mapAccessoriFieldType($inputs['user_type_id']);
                        if (!Schema::hasTable($table_accessories)) {
                            Schema::create($table_accessories, function (Blueprint $table) use ($mapAccessoriesFieldType) {
                                // $table->id();
                                $table->integer('id')->nullable();
                                $table->$mapAccessoriesFieldType('value');
                            });
                        }
                    }

                    if (isset($inputs['btn_action']) && ($inputs['btn_action'] == 'apply')) {
                        return redirect()->route('august.userfield.edit', ['id_block' => $inputs['ablock_id'], 'id_userfield' => $fieldId]);
                    } else {
                        return redirect()->route('august.userfield.index', ['id_block' => $inputs['ablock_id']]);
                    }
                } catch (\Illuminate\Database\QueryException $exception) {
                    return back()->withErrors(['exception' => $exception->getMessage()]);
                }
            }
        } else {
            // update userfield
            $userField = AExtendblockUserField::where('id', $inputs['id'])->first();
            $userField->xml_id = $inputs['xml_id'];
            $userField->sort = $inputs['sort'];
            $userField->show_filter = $inputs['show_filter'];
            $userField->multiple = $inputs['multiple'];
            $userField->mandatory = $inputs['mandatory'];
            $userField->show_in_list = $inputs['show_in_list'];
            $userField->edit_in_list = $inputs['edit_in_list'];
            $userField->show_add_form = $inputs['show_add_form'];
            $userField->show_edit_form = $inputs['show_edit_form'];
            $userField->add_read_only_field = $inputs['add_read_only_field'];
            $userField->edit_read_only_field = $inputs['edit_read_only_field'];
            $userField->show_field_preview = $inputs['show_field_preview'];
            $userField->is_searchable = $inputs['is_searchable'];
            $userField->settings = json_encode($inputs['settings']);            
            $userField->save();

            // update userfield lang
            AExtendblockUserFieldLang::where('user_field_id', $inputs['id'])->delete();
            foreach ($inputs['lang'] as $key => $value) {
                AExtendblockUserFieldLang::create(array(
                    "user_field_id" => $inputs['id'],
                    "lang_id" => $key,
                    "edit_form_label" => $value['edit_form_label'],
                    "list_column_label" => $value['list_column_label'],
                    "list_filter_label" => $value['list_filter_label'],
                    "error_message_label" => $value['error_message_label'],
                    "help_message_label" => $value['help_message_label'],
                ));
            }

            if (isset($inputs['enum_settings'])) {
                // dd($inputs['enum_settings']);
                AExtendblockUserFieldEnum::where('user_field_id', $inputs['id'])->delete();

                $indDef = isset($inputs['enum_settings']['default'][0]) ? $inputs['enum_settings']['default'][0] : 0;

                foreach ($inputs['enum_settings']['xml_id'] as $key => $xmlId) {
                    if (empty($inputs['enum_settings']['value'][$key]) || empty($inputs['enum_settings']['sort'][$key]) || empty($xmlId)) {
                        continue;
                    }
                    $def = ($inputs['enum_settings']['index'][$key] == $indDef) ? 1 : 0;

                    AExtendblockUserFieldEnum::create([
                        'user_field_id' => $inputs['id'],
                        'value' => $inputs['enum_settings']['value'][$key],
                        'sort' => $inputs['enum_settings']['sort'][$key],
                        'xml_id' => $xmlId,
                        'def' => $def
                    ]);
                }
            }

            if (isset($inputs['btn_action']) && ($inputs['btn_action'] == 'apply')) {
                return redirect()->route('august.userfield.edit', ['id_block' => $inputs['ablock_id'], 'id_userfield' => $inputs['id']]);
            } else {
                return redirect()->route('august.userfield.index', ['id_block' => $inputs['ablock_id']]);
            }
        }
    }

    public function delete($ablockId, $fieldId) {
        $userField = AExtendblockUserField::findOrFail($fieldId);

        $ablock = AExtendblockEntity::findOrFail($ablockId);

        $field_name = strtolower($userField->field_name);

        $table_name = $ablock->table_name;
        

        if (!empty($field_name) && !empty($table_name)) {
            DB::statement("ALTER TABLE `{$table_name}` DROP COLUMN `{$field_name}`");

            $table_by_field = strtolower($table_name.'_'.$userField->field_name);
            DB::statement("DROP TABLE IF EXISTS `{$table_by_field}`");

            // $user_field_lang = AExtendblockUserFieldLang::where('user_field_id',$fieldId)->get();
            // if(!empty($user_field_lang)) {
            //     $user_field_lang->each(function ($item) {
            //         $item->delete();
            //     });
            // }

            AExtendblockUserFieldLang::where('user_field_id', $fieldId)->delete();

            $result = $userField->delete();

            if ($result) {
                return redirect()->route('august.userfield.index', ['id_block' => $ablockId]);
            }
        }
    }
}