<?php

namespace Package\August\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Package\August\Http\Controllers\UtilityController;
use Package\August\Http\Controllers\AExtendblockEntityRightsController;
use Package\August\Http\Controllers\AExtendblockUserController;
use Package\August\Http\Controllers\AExtendblockUserRoleController;
use Package\August\Http\Controllers\ATaskController;

use Package\August\Models\AExtendblockEntity;
use Package\August\Models\AExtendblockEntityLang;
use Package\August\Models\AExtendblockFile;
use Package\August\Models\AExtendblockUserField;
use Package\August\Models\AExtendblockUserFieldLang;
use Package\August\Models\AExtendblockUserFieldEnum;
use Package\August\Models\AExtendblockUserMeta;
use Package\August\Models\AExtendblockUsers;
use Package\August\Models\ATask;
use Package\August\Models\AExtendblockElementRights;
use Package\August\Models\AUserAccess;
use Package\August\Models\AExtendblockViewMode;
use Package\August\Models\AExtendblockFilterMode;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ListsController extends BaseController {
    const LIMIT = 5;

    public static function getList($arParams) {
        $ablockId = $arParams['ABLOCK_ID'];

        $currentPage = isset($arParams['PAGE']) ? (int) $arParams['PAGE'] : 1;
        $filter = isset($arParams['FILTER']) ? $arParams['FILTER'] : array();
        $limit = isset($arParams['LIMIT']) ? $arParams['LIMIT'] : self::LIMIT;
        $isUpdateFilterMode = isset($arParams['IS_UPDATE_FILTER_MODE']) ? $arParams['IS_UPDATE_FILTER_MODE'] : false;

        // get current lang
        $curLang = app()->getLocale();
        // dd($curLang);

        // get infor ablock
        $arResults['BLOCK'] = AExtendblockEntity::where("id", $ablockId)->first();

        if (!$arResults['BLOCK']) {
            return false;
        }

        // get ablock lang
        $blockLang = AExtendblockEntityLang::where('block_id', $ablockId)->where('lid', $curLang)->first();
        if ($blockLang) {
            $arResults['PAGE_TITLE'] = $blockLang->name;
        } else {
            $arResults['PAGE_TITLE'] = $arResults['BLOCK']->name;
        }

        // dd($arResults['BLOCK_LANG']);

        // get user fields
        $arUserField = AExtendblockUserField::where("entity_id", 'A_BLOCK_' . $ablockId)->orderBy('sort', 'asc')->get();

        // get array id of user field lang
        $arUserFieldID = array();
        foreach ($arUserField as $key => $value) {
            $arUserFieldID[] = $value["id"];
        }

        // get user field lang
        $arUserFieldLang = AExtendblockUserFieldLang::whereIn('user_field_id', $arUserFieldID)->where('lang_id', $curLang)->get();

        // Header column
        $arResults['COLUMNS'] = array();
        foreach ($arUserField as $userField) {
            $arResults['USER_FIELD'][$userField["field_name"]] = $userField->getAttributes();
            $arResults['USER_FIELD'][$userField["field_name"]]['list_filter_label'] = $userField["field_name"];
            $arResults['COLUMNS'][$userField["field_name"]] = $userField["field_name"];

            foreach ($arUserFieldLang as $lang) {
                if ($userField['id'] == $lang['user_field_id']) {
                    if (!empty($lang["list_column_label"])) {
                        $arResults['COLUMNS'][$userField["field_name"]] = $lang["list_column_label"];
                    }

                    if (!empty($lang["list_filter_label"])) {
                        $arResults['USER_FIELD'][$userField["field_name"]]['list_filter_label'] = $lang["list_filter_label"];
                    }

                    break;
                }
            }

            // get list value for enum field
            if ($userField["user_type_id"] == 'enum') {
                $listEnum = AExtendblockUserFieldEnum::where("user_field_id", $userField["id"])->orderBy('sort', 'asc')->get();

                foreach ($listEnum as $enum) {
                    $arResults['USER_FIELD'][$userField["field_name"]]['list_enum'][$enum->xml_id] = array(
                        "id" => $enum->id,
                        "user_field_id" => $enum->user_field_id,
                        "value" => $enum->value,
                        "def" => $enum->def,
                        "sort" => $enum->def,
                        "xml_id" => $enum->xml_id,
                    );
                }
            }
        }

        // get list element
        // set query
        $query = DB::table($arResults['BLOCK']->table_name);

        // check join
        foreach ($filter as $key => $value) {
            if (!in_array($key, array_keys($arResults['USER_FIELD']))) {
                continue;
            }

            if (empty($value)) {
                continue;
            }

            if ($arResults['USER_FIELD'][$key]['multiple'] == 'Y') {
                $table_field_multi_name = $arResults['BLOCK']->table_name . "_" . strtolower($arResults['USER_FIELD'][$key]['field_name']);
                $query->leftJoin($table_field_multi_name, $arResults['BLOCK']->table_name.'.id', '=', $table_field_multi_name.'.id');
            }
        }

        $filterMode = array();
        foreach ($filter as $key => $value) {
            if (!in_array($key, array_keys($arResults['USER_FIELD']))) {
                continue;
            }

            if (empty($value)) {
                continue;
            }

            $filterMode[$key] = $value;

            if ($arResults['USER_FIELD'][$key]['multiple'] == 'Y') {
                $table_field_multi_name = $arResults['BLOCK']->table_name . "_" . strtolower($arResults['USER_FIELD'][$key]['field_name']);
                $query->where($table_field_multi_name .".value", $value);
            } else {
                if (in_array($arResults['USER_FIELD'][$key]['user_type_id'], array('date', 'datetime'))) {
                    if ($value["FROM"] == null && $value["TO"] == null) {
                        continue;
                    } elseif ($value["FROM"] != null && $value["TO"] == null) {
                        $value["TO"] = $value["FROM"];
                    } elseif ($value["FROM"] == null && $value["TO"] != null) {
                        $value["FROM"] = $value["TO"];
                    }

                    $query->whereBetween(strtolower($key), $value);
                } elseif (is_array($value)) {
                    $query->whereIn(strtolower($key), $value);
                } else {
                    if (in_array($arResults['USER_FIELD'][$key]['user_type_id'], array('string'))) {
                        $query->where(strtolower($key), 'like', '%'.$value.'%');
                    } else {
                        $query->where(strtolower($key), $value);
                    }
                }
            }
        }

        // dd($filter);

        // dd($query->dumpRawSql());

        // save filter mode
        if ($isUpdateFilterMode) {
            if (!empty($filterMode)) {
                AExtendblockFilterMode::where(array('eb_id' => $ablockId, 'user_id' => $arParams['USER_ID']))->delete();
                $filterMode['LIMIT'] = $limit;

                AExtendblockFilterMode::create(array(
                    'eb_id' => $ablockId,
                    'user_id' => $arParams['USER_ID'],
                    'filter_mode' => json_encode($filterMode)
                ));
            } elseif (empty($filterMode) && $limit != self::LIMIT) {
                $res = AExtendblockFilterMode::where(array('eb_id' => $ablockId, 'user_id' => $arParams['USER_ID']))->first();

                if ($res) {
                    $filter_mode = json_decode($res->filter_mode, true);
                    $filter_mode['LIMIT'] = $limit;

                    $res->filter_mode = json_encode($filter_mode);
                    $res->save();
                } else {
                    $filter_mode = array('LIMIT' => $limit);

                    // dd($filter_mode);

                    AExtendblockFilterMode::create(array(
                        'eb_id' => $ablockId,
                        'user_id' => $arParams['USER_ID'],
                        'filter_mode' => json_encode($filter_mode)
                    ));
                }
            }
        }


        // element not access for current user
        if (isset($arParams['ELEMENT_NOT_ACCESS']) && !empty($arParams['ELEMENT_NOT_ACCESS'])) {
            $query->whereNotIn('id', $arParams['ELEMENT_NOT_ACCESS']);
        }

        // calculate total item
        $totalItems = $query->count();

        if ($limit != -1) {
            $offset = ($currentPage - 1) * $limit;
            $arItems = $query->offset($offset)->limit($limit);
        }
        $arItems = $query->get();

        $arResults['ITEMS'] = array();
        foreach ($arItems as $item) {
            if (!isset($item->id) || empty($item->id)) {
                continue;
            }
            $elementId = $item->id;

            $row = array();
            foreach ($arResults['USER_FIELD'] as $userField) {
                $key = $userField["field_name"];
                $row[$key] = array(
                    'value' => '',
                    'user_type_id' => $userField["user_type_id"],
                    'user_field' => $userField
                );

                if ($userField["user_type_id"] == "enum") {
                    $row[$key]["list_enum"] = $userField["list_enum"];
                }

                // column in table db is lower
                $keyDB = strtolower($key);

                // check field is multi, get value from table multi
                if ($userField["multiple"] == "Y") {
                    $table_field_multi_name = $arResults['BLOCK']->table_name . "_" . strtolower($userField['field_name']);
                    $res = DB::table($table_field_multi_name)->select('value')->where('id', $elementId)->get()->toArray();

                    $data = array();
                    foreach ($res as $val) {
                        $data[] = $val->value;
                    }

                    // check field is file
                    if ($userField["user_type_id"] == "file") {
                        $list_image = [];
                        foreach($data as $pic) {
                            $file = AExtendblockFile::where('id', $pic)->first();
                            if ($file) {
                                $extension = pathinfo($file->name, PATHINFO_EXTENSION);
                                $is_image = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);

                                $file = $file->toArray();
                                $file['extension'] = $extension;
                                $file['is_image'] = $is_image;
                                $file['field_name'] = $userField['field_name'];
                                $file['ablock_id'] = $arResults['BLOCK']->id;
                            }

                            $list_image[] = $file;
                        }

                        $row[$key]['value'] = $list_image;
                        continue;
                    }

                    // check is link to element
                    if ($userField["user_type_id"] == 'link_to_element') {
                        $listLinkToElement = array();
                        $settingField = json_decode($userField['settings'], true);

                        if (isset($settingField['show_field'])) {
                            foreach($data as $id_el) {
                                $listLinkToElement[] = UtilityController::getShowFieldElement($settingField['link_to_ablock'], strtolower($settingField['show_field']), $id_el, true);
                            }
                        }

                        $row[$key]['value'] = $listLinkToElement;
                        continue;
                    }

                    $row[$key]['value'] = $data;
                    continue;
                }

                // check field is file
                if ($userField["user_type_id"] == "file") {
                    $file = AExtendblockFile::where('id', $item->$keyDB)->first();
                    if ($file) {
                        $file = $file->toArray();
                        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                        $file['is_image'] = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                        $file['extension'] = $extension;
                        $row[$key]['value'] = $file;
                    }

                    continue;
                }

                // check is link to user
                if (($userField["user_type_id"] == 'link_to_user') && isset($item->$keyDB) && !empty($item->$keyDB)) {
                    $user = AExtendblockUsers::where('id', $item->$keyDB)->first();
                    if ($user) {
                        $user = $user->toArray();
                        $row[$key]['value'] = $user;
                    }

                    continue;
                }

                // check is link to element
                if (($userField["user_type_id"] == 'link_to_element') && isset($item->$keyDB) && !empty($item->$keyDB)) {
                    $settingField = json_decode($userField['settings'], true);

                    if (!isset($settingField['show_field'])) {
                        continue;
                    }

                    $row[$key]['value'] = UtilityController::getShowFieldElement($settingField['link_to_ablock'], strtolower($settingField['show_field']), $item->$keyDB, true);

                    continue;
                }

                if (isset($item->$keyDB)) {
                    $row[$key]['value'] = $item->$keyDB;
                }
            }

            $arResults['ITEMS'][] = $row;
        }

        $arResults['PAGE'] = $currentPage;
        
        $arResults['TOTAL_PAGES'] = $totalItems;
        if (!empty($limit) && ($limit != -1)) {
            $arResults['TOTAL_PAGES'] = ceil($totalItems / $limit);
        }

        $arResults['TOTAL_ITEMS'] = $totalItems;
        $arResults['LIMIT'] = $limit;
        $arResults['FILTER_MODE'] = $filterMode;
        // dd($arResults['ITEMS']);
        // dd($arResults);

        return $arResults;
    }

    public function index(Request $request, $ablockId) {
        $userId = Auth::id();

        // get right of block by user id and ablock id
        $letter = AExtendblockEntityRightsController::getAccess($ablockId, $userId);

        // ablock deny
        if ($letter == 'D') {
            return view('August::templates.default.not-permission');
        }

        // get all access by letter
        $arActionAccess = AExtendblockEntityRightsController::actionAccess($letter);

        if ($arActionAccess['VIEW_LIST_ELEMENT'] == 'N') {
            return view('August::templates.default.not-permission');
        }

        // filter
        $_POST = $request->post();
        $filter = null;
        $isUpdateFilterMode = false;
        if (isset($_POST['filter_mode']) && ($_POST['filter_mode']['reset'] == 1)) {
            AExtendblockFilterMode::where(array('eb_id' => $ablockId, 'user_id' => $userId))->delete();
        } elseif (isset($_POST['filter_mode']) && ($_POST['filter_mode']['reset'] == 0)) {
            $filter = $_POST['filter_mode'];
            $isUpdateFilterMode = true;
        } else {
            $flterMode = AExtendblockFilterMode::where(array('eb_id' => $ablockId, 'user_id' => $userId))->first();
            if ($flterMode) {
                $filter = json_decode($flterMode->filter_mode, true);
            }
        }

        // get list element not access to curent user and ablock id
        $arNotAccessElementId = AExtendblockElementRightsController::getNotAccessByUserId($ablockId, $userId);

        $page = $request->input('page', 1);

        // check isset request limit
        if ($request->input('limit')) {
            $isUpdateFilterMode = true;
            $limit = $request->input('limit');
        } elseif (isset($filter['LIMIT'])) {
            $limit = $filter['LIMIT'];
        } else {
            $limit = self::LIMIT;
        }

        $arParams = array('ABLOCK_ID' => $ablockId, 'ACTION_ACCESS' => $arActionAccess);
        $arResults = $this->getList(array(
            'ABLOCK_ID' => $ablockId,
            'PAGE' => $page,
            'FILTER' => $filter,
            'ELEMENT_NOT_ACCESS' => $arNotAccessElementId,
            'USER_ID' => $userId,
            'LIMIT' => $limit,
            'IS_UPDATE_FILTER_MODE' => $isUpdateFilterMode,

        ));

        if (!$arResults) {
            return view('August::ablock.not-found-ablock', ['arParams' => $arParams]);
        }

        // view mode
        $viewMode = AExtendblockViewMode::where('eb_id', $ablockId)->where('user_id', $userId)->first();

        if ($viewMode) {
            $arMode = json_decode($viewMode->view_mode, true);
            foreach ($arResults['USER_FIELD'] as $key => $value) {
                if (isset($arMode[$key]) &&  $arMode[$key] == 'Y') {
                    $arResults['USER_FIELD'][$key]['show_in_list'] = 'Y';
                } else {
                    $arResults['USER_FIELD'][$key]['show_in_list'] = 'N';
                }
            }

            foreach ($arResults['ITEMS'] as $key => $item) {
                foreach ($item as $keyCel => $cel) {
                    if (isset($arMode[$keyCel]) &&  $arMode[$keyCel] == 'Y') {
                        $arResults['ITEMS'][$key][$keyCel]['user_field']['show_in_list'] = 'Y';
                    } else {
                        $arResults['ITEMS'][$key][$keyCel]['user_field']['show_in_list'] = 'N';
                    }
                }
            }
        }

        $arResults['LIMIT_OPTION'] = array(5, 10, 20, 50, 100, 200, 500);
        $arResults['LIMIT_SELECTED'] = $limit;


        $arResults['TEMPLATE_VIEW_LIST'] = array('August::templates.default.index');
        $ablock = AExtendblockEntity::where("id", $ablockId)->first();
        $settings = $ablock->settings;
        if (!empty($settings)) {
            $settings = json_decode($settings, true);
            if (isset($settings["template_view_list"]) && is_array($settings["template_view_list"])) {
                foreach ($settings["template_view_list"] as $key => $value) {
                    $arResults['TEMPLATE_VIEW_LIST'][] = $value;
                }
            }
        }

        $template = 'August::templates.default.index';
        if ($request->input("template")) {
            $template = $request->template;
        }
        
        return view($template, ['arResults' => $arResults, 'arParams' => $arParams]);
    }

    public function store(Request $request) {
        $userId = Auth::id();
        $inputs = $request->input();

        $ablock = AExtendblockEntity::where("id", $inputs['id_block'])->first();

        $arUserField = AExtendblockUserField::where("entity_id", 'A_BLOCK_' . $inputs['id_block'])->orderBy('sort', 'asc')->get();

        // full_text_search
        $full_text_search = "";

        // add column full_text_search if not exists
        if (!Schema::hasColumn($ablock->table_name, 'full_text_search')) {
            Schema::table($ablock->table_name, function (Blueprint $table) {
                $table->longText('full_text_search')->nullable();
            });

            AExtendblockUserField::create([
                "entity_id" => "A_BLOCK_".$inputs['id_block'],
                "user_type_id" => "string",
                "field_name" => "FULL_TEXT_SEARCH",
                "xml_id" => "FULL_TEXT_SEARCH",
                "show_add_form" => "N",
                "show_edit_form" => "N",
                "show_in_list" => "N",
                "sort" => 1000,
                "show_filter" => "N"
            ]);
        }

        $row = array();
        foreach ($arUserField as $userField) {
            $field = $userField->field_name;
            $fieldValue = $request->$field;

            // check field is multi
            if ($userField->multiple == "Y") {
                $row[strtolower($field)] = null;
                continue;
            }

            // check field is phone
            if($userField->user_type_id == "phone") {
                if(!preg_match('/^0[0-9]{9,10}$/', $fieldValue)) {
                    return back()->withErrors(['field_phone.not_fomat' => trans('August::validation.field_phone.not_fomat')]);
                }
            }

            // check field is link
            if($userField->user_type_id == "link") {
                if(!preg_match('/\b(?:https?|ftp):\/\/[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)+(?:\/[^\s]*)?$/i', $fieldValue)) {
                    return back()->withErrors(['field_link.not_fomat' => trans('August::validation.field_link.not_fomat')]);
                }
            }

            // check field is html
            if ($userField->user_type_id == "html") {
                $fieldValue = htmlentities($fieldValue);
            }

            // check field is file
            if ($userField->user_type_id == "file") {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);

                    $year = Carbon::now()->year;
                    $month = Carbon::now()->format('m');
                    $path = "$year/$month";

                    $fileStore = time().'.'.$file->getClientOriginalExtension();
                    $filePath = $file->storeAs($path, $fileStore, 'public');
                    $fileName = $file->getClientOriginalName();

                    $fieldValue = AExtendblockFile::create(array(
                        "name" => $fileName,
                        "path" => $filePath,
                        "author" => $userId
                    ))->id;
                } elseif (isset($inputs[$userField->field_name.'_old']) && !empty($inputs[$userField->field_name.'_old'])) {
                    $fieldValue = $inputs[$userField->field_name.'_old'];
                }
            }

            // check field is link to user
            if ($userField->user_type_id == "link_to_user" && !empty($request->$field)) {
                $fieldValue = trim($request->$field, ",");
            }

            // check field is full text search
            if ($userField->settings) {
                $settings = json_decode($userField->settings, true);

                if (isset($settings["full_text_search"]) && ($settings["full_text_search"] == "Y")) {
                    $full_text_search .= $fieldValue;
                }
            }

            $row[strtolower($field)] = $fieldValue;
        }

        $row['full_text_search'] = $full_text_search;

        // dd($row);

        if (!isset($inputs['id_element']) || (intval($inputs['id_element']) == 0)) {
            $elementId = DB::table($ablock->table_name)->insertGetId($row);
        } else {
            unset($row['id']);

            DB::table($ablock->table_name)->where('id', $inputs['id_element'])->update($row);

            $elementId = $inputs['id_element'];
        }

        // save for multi field
        foreach ($arUserField as $userField) {
            if ($userField->multiple != "Y") {
                continue;
            }

            $field = $userField->field_name;


            $fieldValue = $request->$field;
            $table_field_multi_name = $ablock->table_name . "_" . strtolower($field);

            // check field is file and multi
            if ($userField->user_type_id == "file" && $userField->multiple == "Y") {
                $fieldValue = null;
                if ($request->hasFile($field)) {
                    $files = $request->file($field);

                    foreach ($files as $file) {
                        $year = Carbon::now()->year;
                        $month = Carbon::now()->format('m');
                        $path = "$year/$month";

                        $fileStore = time().rand(10, 100).'.'.$file->getClientOriginalExtension();
                        $filePath = $file->storeAs($path, $fileStore, 'public');
                        $fileName = $file->getClientOriginalName();

                        $fieldValue[] = AExtendblockFile::create(array(
                            "name" => $fileName,
                            "path" => $filePath,
                            "author" => $userId
                        ))->id;
                    }
                }

                if (isset($inputs[$userField->field_name.'_old']) && !empty($inputs[$userField->field_name.'_old'])) {
                    foreach ($inputs[$userField->field_name.'_old'] as $fileOldId) {
                        $fieldValue[] = $fileOldId;
                    }
                }
            }

             // check field is phone and multi
             if($userField->user_type_id == "phone" && $userField->multiple == "Y") {
                foreach($fieldValue as $value) {
                    if(!preg_match('/^0[0-9]{9,10}$/', $value)) {
                        return back()->withErrors(['field_phone.not_fomat' => trans('August::validation.field_phone.not_fomat')]);
                    }
                }
            }

            // check field is link and multi
            if($userField->user_type_id == "link" && $userField->multiple == "Y") {
                foreach($fieldValue as $value) {
                    if(!preg_match('/\b(?:https?|ftp):\/\/[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)+(?:\/[^\s]*)?$/i', $value)) {
                        return back()->withErrors(['field_link.not_fomat' => trans('August::validation.field_link.not_fomat')]);
                    }
                }
            }

            DB::table($table_field_multi_name)->where('id', $elementId)->delete();

            $data = array();
            if (is_array($fieldValue)) {
                foreach ($fieldValue as $key => $value) {
                    if (empty($value)) {
                        continue;
                    }

                    $data[] = array(
                        "id" => $elementId,
                        'value' => $value
                    );
                }
            } elseif (!empty($fieldValue)) {
                $data[] = array(
                    "id" => $elementId,
                    'value' => $fieldValue
                );
            }

            if (!empty($data)) {
                DB::table($table_field_multi_name)->insert($data);
            }
        }

        if (isset($inputs['entity_access'])) {
            self::saveAccess($inputs['entity_access'], $request->id_block, $elementId);
        }

        if (isset($request->btn_action) && ($request->btn_action == 'apply')) {
            return redirect()->route('august.lists.edit', ['id_block' => $request->id_block, 'id_element' => $elementId]);
        } else {
            return redirect()->route('august.lists.index', ['id_block' => $request->id_block]);
        }
    }

    public function edit($ablockId, $elementId) {
        $arResults = UtilityController::getInfoElement($ablockId, $elementId);
        return view('August::templates.default.add', ['arResults' => $arResults]);
    }

    public function copy($ablockId, $elementId) {
        $arResults = UtilityController::getInfoElement($ablockId, $elementId);
        $arResults["ELEMENT_ID"] = 0;
        return view('August::templates.default.add', ['arResults' => $arResults]);
    }

    public function getElement($ablockId, $elementId) {
        $arResults = UtilityController::getInfoElement($ablockId, $elementId);
        return $arResults;
    }

    public function preview($ablockId, $elementId) {
        $arResults = UtilityController::getInfoElement($ablockId, $elementId);
        return view('August::templates.default.preview', ['arResults' => $arResults]);
    }

    public function add($ablockId) {
        // get current lang
        $curLang = app()->getLocale();

        $arResults = array('ABLOCK_ID' => $ablockId, "ELEMENT_ID" => 0);
        // get user fields
        $arUserField = AExtendblockUserField::where("entity_id", 'A_BLOCK_' . $ablockId)->orderBy('sort', 'asc')->get();

        // get array id of user field lang
        $arUserFieldID = array();
        foreach ($arUserField as $key => $value) {
            $arUserFieldID[] = $value["id"];
        }

        // get user field lang
        $arUserFieldLang = AExtendblockUserFieldLang::whereIn('user_field_id', $arUserFieldID)->where('lang_id', $curLang)->get();

        foreach ($arUserField as $userField) {
            $arResults['USER_FIELD'][$userField["field_name"]] = $userField->getAttributes();
            $arResults['USER_FIELD'][$userField["field_name"]]['edit_form_label'] = $userField["field_name"];

            foreach ($arUserFieldLang as $lang) {
                if ($userField['id'] == $lang['user_field_id']) {
                    if (!empty($lang["edit_form_label"])) {
                        $arResults['USER_FIELD'][$userField["field_name"]]['edit_form_label'] = $lang["edit_form_label"];
                    }

                    break;
                }
            }

            // get list value for enum field
            if ($userField["user_type_id"] == 'enum') {
                $listEnum = AExtendblockUserFieldEnum::where("user_field_id", $userField["id"])->orderBy('sort', 'asc')->get();

                foreach ($listEnum as $enum) {
                    $arResults['USER_FIELD'][$userField["field_name"]]['list_enum'][$enum->xml_id] = array(
                        "id" => $enum->id,
                        "user_field_id" => $enum->user_field_id,
                        "value" => $enum->value,
                        "def" => $enum->def,
                        "sort" => $enum->def,
                        "xml_id" => $enum->xml_id
                    );
                }
            }
        }

        // get infor ablock
        $arResults['BLOCK'] = AExtendblockEntity::where("id", $ablockId)->first();

        $arResults['USERS'] = AExtendblockUserController::getList();
        $arResults['ROLES'] = AExtendblockUserRoleController::getList();
        $arResults['TASK'] = ATaskController::getListByModuleID("a_extend_block");
        $arResults['RIGHT'] = array();

        return view('August::templates.default.add', ['arResults' => $arResults]);
    }

    public function getElementById(Request $request) {
        $ablockId = $request->input('id');
        $userField = $request->input('userField');
        $showField = $request->input('showField');
        $page = $request->input('page');
        $multiple = $request->input('multiple');

        $arElements = $this->getList(array('ABLOCK_ID' => $ablockId, 'LIMIT' => 5, 'PAGE' => $page,));
        $arResults = ['arElements' => $arElements, 'userField' => $userField, 'showField' => $showField, 'ablockId' => $ablockId, "multiple" => $multiple];

        return view('August::widgets.link_to_element_popup', $arResults);
    }

    public function getElementsLinkTo(Request $request) {
        $inputs = $request->input();

        $ablockId = $request->input('id');
        $userField = $request->input('userField');
        $showField = $request->input('showField');
        $page = isset($inputs['page']) ? $inputs['page'] : 1;
        $search = isset($inputs['search']) ? $inputs['search'] : '';
        $multiple = $request->input('multiple');

        $arParams = array(
            'ABLOCK_ID' => $ablockId,
            'LIMIT' => 5,
            'PAGE' => $page
        );

        if (!empty($search)) {
            $arParams["FILTER"][$showField] = $search;
        }

        $arElements = $this->getList($arParams);

        $arResults = ['arElements' => $arElements, 'userField' => $userField, 'showField' => $showField, 'ablockId' => $ablockId, "multiple" => $multiple];

        return view('August::widgets.link_to_element_popup', $arResults);
    }

    public function delete($ablockId, $elementId) {
        $arResults['BLOCK'] = AExtendblockEntity::where("id", $ablockId)->first();

        $result = DB::table($arResults['BLOCK']->table_name)->where("id", $elementId)->delete();

        if ($result) {
            return redirect()->route('august.lists.index', ['id_block' => $ablockId]);
        }
    }

    // access
    public static function saveAccess($arAccess, $ablockId, $elementId) {
        // get task
        $objATask = ATask::where('module_id', "a_extend_block")->get();

        $arAtask = array();
        foreach ($objATask as $aTask) {
            $arAtask[$aTask->letter] = $aTask->id;
        }

        AExtendblockElementRights::where('eb_id', $ablockId)->where('element_id', $elementId)->delete();

        foreach ($arAccess as $access) {
            if (!isset($arAtask[$access['access']])) {
                continue;
            }

            // save for a_extendblock_entity_rights
            AExtendblockElementRights::create(array(
                'eb_id' => $ablockId,
                'element_id' => $elementId,
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

    public function importExcel(Request $request, $ablockId) {
        $ablock = AExtendblockEntity::where("id", $ablockId)->first();

        if ($request->hasFile('FILE')) {
            if ($ablock) {
                $arUserField = AExtendblockUserField::where("entity_id", 'A_BLOCK_' . $ablockId)->orderBy('sort', 'asc')->get();
                $arFieldSave = array();
                foreach ($arUserField as $key => $value) {
                    if ($value->field_name == 'ID') {
                        continue;
                    }

                    $arFieldSave[] = $value->field_name;
                }

                $files = $request->file('FILE');

                foreach ($files as $key => $file) {
                    $year = Carbon::now()->year;
                    $month = Carbon::now()->format('m');
                    $path = "$year/$month";

                    $fileStore = time().'.'.$file->getClientOriginalExtension();
                    $filePath = $file->storeAs($path, $fileStore, 'public');

                    // dd($filePath);

                    $inputFileName = $_SERVER["DOCUMENT_ROOT"].'/storage/app/public/'.$filePath;

                    $inputFileType = 'Xlsx';
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                    $reader->setReadDataOnly(true);

                    // $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                    $spreadSheet = $reader->load($inputFileName);
                    $workSheet = $spreadSheet->getActiveSheet();
                    $dataArray = $workSheet->toArray();

                    $arHeader = $dataArray[0];
                    foreach ($dataArray as $key => $row) {
                        if ($key == 0) {
                            continue;
                        }

                        $record = array();
                        foreach ($row as $cell => $value) {
                            if (!in_array($arHeader[$cell], $arFieldSave)) {
                                continue;
                            }

                            $record[strtolower($arHeader[$cell])] = $value;
                        }

                        DB::beginTransaction();
                        try {
                            DB::table($ablock->table_name)->insert($record);
                            DB::commit();
                        } catch (\Exception $e) {
                            DB::rollback();
                        }
                    }
                }

                return redirect()->route('august.lists.index', ['id_block' => $ablockId]);
            }
        }

        $arResults = array('BLOCK_ID' => $ablockId, 'TABLE_NAME' => $ablock->table_name);
        return view('August::templates.default.import-excel', ['arResults' => $arResults]);
    }

    public function exportExcel($ablockId) {
        // test tạo file excel ở thư mục public
        // $spreadsheet = new Spreadsheet();
        // $activeWorksheet = $spreadsheet->getActiveSheet();
        // $activeWorksheet->setCellValue('A1', 'Hello World !');
        // $writer = new Xlsx($spreadsheet);
        // $writer->save('hello world.xlsx');


        $arResults = array();
        return view('August::templates.default.export-excel', ['arResults' => $arResults]);
    }

    // save view mode
    public function viewMode(Request $request) {
        $inputs = $request->input();
        AExtendblockViewMode::where('eb_id', $inputs["ablock_id"])->where('user_id', Auth::id())->delete();

        AExtendblockViewMode::create(array(
            'eb_id' => $inputs["ablock_id"],
            'user_id' => Auth::id(),
            'view_mode' => json_encode($inputs["view"]),
        ));

        return redirect()->route('august.lists.index', ['id_block' => $inputs["ablock_id"]]);
    }
}
