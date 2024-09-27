<?php

namespace Package\August\Http\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Package\August\Http\Controllers\UtilityController;

use Package\August\Models\AExtendblockEntity;
use Package\August\Models\AExtendblockEntityLang;
use Package\August\Models\AExtendblockUserField;
use Package\August\Models\AExtendblockUserFieldLang;
use Package\August\Models\ATask;
use Package\August\Models\AExtendblockEntityRights;
use Package\August\Models\AUserAccess;
use Package\August\Models\AExtendblockMenu;

use Package\August\Http\Controllers\AExtendblockUserController;
use Package\August\Http\Controllers\AExtendblockUserRoleController;

class AblockController extends BaseController {
    const LIMIT = 5;
    public function index(Request $request) {
        $arResults['ITEMS'] = AExtendblockEntity::get();
        return view('August::ablock.index', ['arResults' => $arResults]);
    }

    public function add(Request $request) {
        $arParams = array('ablockID' => 0);

        return view('August::ablock.add', ['arParams' => $arParams]);
    }

    public function store(Request $request) {
        // validate
        $messages = [
            'ablock_name.required' => trans('August::validation.ablock_name.required'),
            'table_name.required' => trans('August::validation.table_name.required'),
        ];

        $request->validate([
            'ablock_name' => 'required',
            'table_name' => 'required',
        ], $messages);

        $inputs = $request->input();

        // dd($inputs);

        if (isset($inputs['id']) && (intval($inputs['id']) == 0)) {
            // check ablock exist
            $ablock = AExtendblockEntity::where('name', $inputs['ablock_name'])->first();
            $ablock_table_name = AExtendblockEntity::where('table_name', $inputs['table_name'])->first();
            
            if (!empty($ablock) || !empty($ablock_table_name)) {
                return back()->withErrors(['ablock_name.exist' => trans('August::validation.ablock_name.exist')]);
            } else {
                try {
                    $ablockId =  AExtendblockEntity::create(array(
                        "name" => $inputs['ablock_name'],
                        "table_name" => $inputs['table_name'],
                        "description" => $inputs['description'],
                        "sort" => $inputs['sort'],
                        "settings" => isset($inputs['settings']) ? json_encode($inputs['settings']) : '',
                    ))->id;

                    if (!Schema::hasTable($inputs['table_name'])){
                        Schema::create($inputs['table_name'], function (Blueprint $table) {
                            $table->id();
                            $table->longText('full_text_search')->collation('utf8_unicode_ci')->nullable();
                            $table->timestamps();
                        });
                    }

                    // add column id
                    AExtendblockUserField::create([
                        "entity_id" => "A_BLOCK_".$ablockId,
                        "user_type_id" => "int",
                        "field_name" => "ID",
                        "xml_id" => "ID",
                        "show_add_form" => "N",
                        "show_edit_form" => "N",
                        "sort" => 10,
                        "show_filter" => "I"
                    ]);

                    // add column full text search
                    AExtendblockUserField::create([
                        "entity_id" => "A_BLOCK_".$ablockId,
                        "user_type_id" => "string",
                        "field_name" => "FULL_TEXT_SEARCH",
                        "xml_id" => "FULL_TEXT_SEARCH",
                        "show_add_form" => "N",
                        "show_edit_form" => "N",
                        "show_in_list" => "N",
                        "sort" => 1000,
                        "show_filter" => "N"
                    ]);

                    if (!empty($request->input('langs.en'))) {
                        AExtendblockEntityLang::create(array(
                            'block_id' => $ablockId,
                            'lid' => 'en',
                            'name' => $request->input('langs.en')
                        ));
                    }

                    if (!empty($request->input('langs.vi'))) {
                        AExtendblockEntityLang::create(array(
                            'block_id' => $ablockId,
                            'lid' => 'vi',
                            'name' => $request->input('langs.vi')
                        ));
                    }

                    // add to left menu
                    if (!empty($inputs['settings']) && ($inputs['settings']['show_in_left_menu'] == 'Y')) {
                        $menuTitle = $inputs['settings']['title_in_left_menu'];
                        $menuSort = $inputs['settings']['sort_in_left_menu'];
                        AExtendblockMenu::create(array(
                            'menu_id' => 'list_'.$inputs['id'],
                            'item_code' => 'list_'.$inputs['id'],
                            'menu_group' => 'admin_left_menu',
                            'menu_title' => $menuTitle,
                            'menu_sort' => $menuSort,
                            'menu_link' => '/august/lists/'.$ablockId
                        ));
                    }
                    
                    if (isset($inputs['btn_action']) && ($inputs['btn_action'] == 'apply')) {
                        return redirect()->route('august.ablock.edit', ['field_id' => $ablockId]);
                    } else {
                        return redirect()->route('august.ablock.index');
                    }
                } catch (\Illuminate\Database\QueryException $exception) {
                    return back()->withErrors(['exception' => trans('August::messages.exception')]);
                }
            }
        } else {
            $ablock = AExtendblockEntity::where('id', $inputs['id'])->first();
            $ablock->name =  $inputs['ablock_name'];
            $ablock->table_name = $inputs['table_name'];
            $ablock->description = $inputs['description'];
            $ablock->sort = $inputs['sort'];
            $ablock->settings = isset($inputs['settings']) ? json_encode($inputs['settings']) : '';
            $ablock->save();

            AExtendblockEntityLang::where('block_id', $inputs['id'])->delete();
            if (!empty($request->input('langs.en'))) {
                AExtendblockEntityLang::create(array(
                    'block_id' => $inputs['id'],
                    'lid' => 'en',
                    'name' => $request->input('langs.en')
                ));
            }

            if (!empty($request->input('langs.vi'))) {
                AExtendblockEntityLang::create(array(
                    'block_id' => $inputs['id'],
                    'lid' => 'vi',
                    'name' => $request->input('langs.vi')
                ));
            }

            // add to left menu
            if (!empty($inputs['settings']) && ($inputs['settings']['show_in_left_menu'] == 'Y')) {
                $menuTitle = $inputs['settings']['title_in_left_menu'];
                $menuSort = $inputs['settings']['sort_in_left_menu'];

                AExtendblockMenu::where('menu_id', 'list_'.$inputs['id'])->delete();

                AExtendblockMenu::create(array(
                    'menu_id' => 'list_'.$inputs['id'],
                    'item_code' => 'list_'.$inputs['id'],
                    'menu_group' => 'admin_left_menu',
                    'menu_title' => $menuTitle,
                    'menu_sort' => $menuSort,
                    'menu_link' => '/august/lists/'.$inputs['id']
                ));
            }

            if (isset($inputs['entity_access'])) {
                self::saveAccess($inputs['entity_access'], $inputs['id']);
            }

            if (isset($inputs['btn_action']) && ($inputs['btn_action'] == 'apply')) {
                return redirect()->route('august.ablock.edit', ['field_id' => $inputs['id']]);
            } else {
                return redirect()->route('august.ablock.index');
            }
        }
    }

    public function edit($ablockId) {
        $ablockField = AExtendblockEntity::where('id', $ablockId)->first();

        if (!$ablockField) {
            return view('August::ablock.not-found-ablock', ['arParams' => array('ABLOCK_ID' => $ablockId)]);
        }
        
        $arParams = array(
            'ablockID' => $ablockId,
            'ablock_NAME' => $ablockField->name,
            'ablock_TABLE_NAME' => $ablockField->table_name,
            'ablock_DESC' => $ablockField->description,
            'ablock_SORT' => $ablockField->sort,
            'ablock_SETTINGS' => $ablockField->settings,
            'ablock_LANG' => AExtendblockEntityLang::where('block_id',$ablockId)->get(),
        );

        $arResults = array(
            'USERS' => AExtendblockUserController::getList(),
            'ROLES' => AExtendblockUserRoleController::getList(),
            'RIGHT' => AExtendblockEntityRightsController::getlist($ablockId),
            'TASK' => ATaskController::getListByModuleID("a_extend_block")
        );

        // dd($arParams);

        return view('August::ablock.add', ['arParams' => $arParams, 'arResults' => $arResults]);
    }

    public function coppy($ablockId) {
        $ablockField = AExtendblockEntity::where('id', $ablockId)->first();
        $arParams = array(
            'ablockID' => 0,
            'ablock_NAME' => $ablockField->name,
            'ablock_TABLE_NAME' => $ablockField->table_name,
            'ablock_DESC' => $ablockField->description,
            'ablock_SORT' => $ablockField->sort,
            'ablock_LANG' => AExtendblockEntityLang::where('block_id',$ablockId)->get(),
        );

        return view('August::ablock.add', ['arParams' => $arParams]);
    }

    public function delete($ablockId) {
        $ablock = AExtendblockEntity::findOrFail($ablockId);

        if(!empty($ablock)) {
            // delete all lang of ablock
            AExtendblockEntityLang::where('block_id', $ablockId)->delete();

            AExtendblockUserField::where('entity_id', 'A_BLOCK_'.$ablockId)->delete();

            // drop table db
            DB::statement("DROP TABLE IF EXISTS `{$ablock->table_name}`");

            // delete ablock
            $result = $ablock->delete();
            if ($result) {
                return redirect()->back();
            }
        }
    }

    public function listTableDB(Request $request) {
        $dbName = DB::connection()->getDatabaseName();

        $ablocks = AExtendblockEntity::get();

        $tables = DB::select('SHOW TABLES');
        // dd($tables);

        $arResults = array();

        $key = "Tables_in_".$dbName;
        foreach ($tables as $table) {
            if (strpos($table->$key, "a_extendblock_") !== false) {
                continue;
            }
            $arResults[$table->$key] = array(
                "table_name" => $table->$key
            );
        }

        foreach ($arResults as $key => $value) {
            foreach ($ablocks as $ablock) {
                if ($ablock->table_name == $value["table_name"]) {
                    $arResults[$key]["id"] = $ablock->id;
                    $arResults[$key]["name"] = $ablock->name;
                    $arResults[$key]["table_name"] = $ablock->table_name;
                    $arResults[$key]["description"] = $ablock->description;
                }
            }
        }

        $currentPage = $request->input('page', 1);
        $totalItems = count($arResults); 
        $offset = ($currentPage - 1) * self::LIMIT;
        // dd($totalItems);
        $paginateResult = array_slice($arResults, $offset, self::LIMIT);
        $totalPages = ceil($totalItems / self::LIMIT);

        $arParams = array(
            'ITEMS' => $paginateResult,
            'TOTAL_ITEMS' => $totalItems,
            'TOTAL_PAGES' => $totalPages,
            'CURRENT_PAGE' => $currentPage,
        );
        // dd($arParams);
        return view('August::ablock.list-table-db', ['arParams' => $arParams]);
    }

    public function convertToAblock($tableName) {
        $arParams = array(
            'ablockID' => 0,
            'TABLE_NAME' => $tableName
        );
        $arParams['FIELD'] = [];

        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        $columns = array_diff($columns, ['created_at', 'updated_at']);

        foreach ($columns as $column) {
            $arParams['FIELD'][$column] = DB::getSchemaBuilder()->getColumnType($tableName, $column);
        }

        return view('August::ablock.convert-to-ablock', ['arParams' => $arParams]);
    }

    // access
    public static function saveAccess($arAccess, $ablockId) {
        // dd($arAccess);
        AExtendblockEntityRights::where('eb_id', $ablockId)->delete();

        $objATask = ATask::where('module_id', "a_extend_block")->get();
        
        $arAtask = array();
        foreach ($objATask as $aTask) {
            $arAtask[$aTask->letter] = $aTask->id;
        }

        foreach ($arAccess as $access) {
            // get task id
            // $aTask = ATask::where('letter', $access['access'])->where('module_id', "a_extend_block")->first();

            if (!isset($arAtask[$access['access']])) {
                continue;
            }

            // dd($aTask);

            // save for a_extendblock_entity_rights
            AExtendblockEntityRights::create(array(
                'eb_id' => $ablockId,
                'task_id' => $arAtask[$access['access']],
                'access_code' => $access['access_code']
            ));

            // check exists in table a_user_access
            $aUserAccess = AUserAccess::where('user_id', $access['user_id'])->where('provider_id', $access["provider_id"])->where('access_code', $access["access_code"])->first();
            if (!$aUserAccess) {
                AUserAccess::create(array(
                    'user_id' => $access['user_id'],
                    'provider_id' => $access['provider_id'],
                    'access_code' => $access['access_code']
                ));
            }
        }
    }

    // get field
    public function getFields(Request $request) {
        $curLang = app()->getLocale();

        $inputs = $request->input();

        $field_id = AExtendblockUserField::where('entity_id', 'A_BLOCK_' . $inputs['id'])->pluck('id');
        $fields = AExtendblockUserField::leftJoin('a_extendblock_user_field_lang','a_extendblock_user_field.id','=','a_extendblock_user_field_lang.user_field_id')
        ->whereIn('a_extendblock_user_field.id', $field_id)
        ->where('a_extendblock_user_field_lang.lang_id', $curLang)
        ->select('a_extendblock_user_field.field_name AS field_name',
                'a_extendblock_user_field_lang.edit_form_label AS edit_form_label')
        ->get();

        ?>
        <div class="mb-2 row" id="show_field">
            <label class="col-md-3 col-form-label text-end"><?php echo __("August::userfield.show_column") ?></label>
            <div class="col-md-9 align-items-center d-flex">
                <select class="form-control" name="settings[show_field]">
                <?php
                    foreach($fields as $field) {
                    ?>
                    <option value="<?php echo $field->field_name; ?>"><?php echo $field->edit_form_label ? $field->edit_form_label : $field->field_name; ?></option>
                    <?php 
                    }
                ?>
                </select>
            </div>
        </div>
        <?php
    }
}