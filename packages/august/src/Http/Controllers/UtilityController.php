<?php

namespace Package\August\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Package\August\Models\AExtendblockUserFieldType;
use Package\August\Models\AExtendblockEntity;
use Package\August\Models\AExtendblockFile;
use Package\August\Models\AExtendblockUserMeta;
use Package\August\Models\AExtendblockUsers;
use Package\August\Models\AExtendblockMenu;
use Package\August\Models\AExtendblockUserField;
use Package\August\Models\AExtendblockUserFieldLang;
use Package\August\Models\AExtendblockUserFieldEnum;

class UtilityController {
    public static function getUserMenuLeft() {
        $arMenu = array(
            'ADMIN' => array(
                'TITLE' => trans('August::menu.ablock_setting'),
                'TYPE' => 'TITLE_MENU',
                'ROLE' => 'administrator'
            ),
            'USER_FIELD_TYPE' => array(
                'TITLE' => trans('August::menu.user_field_type'),
                "LINK" => '/august/ablock/field/type',
                'TYPE' => 'ITEM_MENU',
                'ROLE' => 'administrator'
            ),
            'ABLOCK' => array(
                'TITLE' => trans('August::ablock.list'),
                "LINK" => '/august/ablock',
                'TYPE' => 'ITEM_MENU',
                'ROLE' => 'administrator'
            ),
            'TABLE_DB' => array(
                'TITLE' => trans('August::ablock.convert_to_ablock'),
                "LINK" => '/august/convert-to-ablock',
                'TYPE' => 'ITEM_MENU',
                'ROLE' => 'administrator'
            ),
            'SITE' => array(
                'TITLE' => trans('August::menu.site_setting'),
                'TYPE' => 'TITLE_MENU',
                'ROLE' => 'administrator'
            ),
            'SITE_SETTING' => array(
                'TITLE' => trans('August::menu.site_setting'),
                "LINK" => '/august/setting',
                'TYPE' => 'ITEM_MENU',
                'ROLE' => 'administrator'
            ),
            'MENU' => array(
                'TITLE' => trans('August::menu.menu_setting'),
                "LINK" => '/august/menu',
                'TYPE' => 'ITEM_MENU',
                'ROLE' => 'administrator'
            ),
            'USER_ROLE' => array(
                'TITLE' => trans('August::userrole.list'),
                "LINK" => '/august/user-role',
                'TYPE' => 'ITEM_MENU',
                'ROLE' => 'administrator'
            ),
            'USER' => array(
                'TITLE' => trans('August::users.list'),
                "LINK" => '/august/users',
                'TYPE' => 'ITEM_MENU',
                'ROLE' => 'administrator'
            ),
            'APPS' => array(
                'TITLE' => trans('August::menu.app'),
                'TYPE' => 'TITLE_MENU'
            ),
            // 'SPEED' => array(
            //     'TITLE' => trans('August::menu.speed'),
            //     "LINK" => '/august/speed/',
            //     'TYPE' => 'ITEM_MENU'
            // ),
            // 'CHAT' => array(
            //     'TITLE' => trans('August::menu.chat'),
            //     "LINK" => '/august/chat/',
            //     'TYPE' => 'ITEM_MENU',
            //     "ICON" => '<i class="ri-message-2-line"></i>'
            // ),
            'FILE' => array(
                'TITLE' => trans('August::menu.file_manager'),
                "LINK" => '/august/file/',
                'TYPE' => 'ITEM_MENU',
                "ICON" => '<i class="ri-folders-line"></i>',
                'ROLE' => 'administrator'
            ),
        );

        $left_menu = AExtendblockMenu::where('menu_group', 'admin_left_menu')->orderBy('menu_sort', 'asc')->get();

        foreach ($left_menu as $key => $value) {
            $arMenu[$value->menu_id] = array(
                'TITLE' => $value->menu_title,
                "LINK" => $value->menu_link,
                'TYPE' => 'ITEM_MENU',
            );
        }

        return $arMenu;
    }

    public static function getUserFieldType() {
        $types = AExtendblockUserFieldType::all();
        $result = [];

        foreach($types as $type) {
            $result[$type->code] = $type->user_field_type;
        }
        return $result;
    }

    public static function mapUserFieldType($fieldType) {
        $types = AExtendblockUserFieldType::all();
        $dbType = [];

        foreach($types as $type) {
            $dbType[$type->code] = $type->db_type;
        }

        if (array_key_exists($fieldType, $dbType)) {
            return $dbType[$fieldType];
        } else {
            return "VARCHAR(255)";
        }
    }

    public static function mapAccessoriFieldType($fieldType) {
        $types = AExtendblockUserFieldType::all();
        $dbType = [];

        foreach($types as $type) {
            $dbType[$type->code] = $type->accessori_type;
        }

        if (array_key_exists($fieldType, $dbType)) {
            return $dbType[$fieldType];
        } else {
            return "VARCHAR(255)";
        }
    }

    // check ablock exists
    public static function checkAblockExists($ablockId) {
        $res = AExtendblockEntity::where("id", $ablockId)->first();
        if (!$res) {
            return false;
        }

        return true;
    }

    public static function getUserById($userId) {
        $user = AExtendblockUsers::where('id', $userId)->first();

        return $user;
    }

    public static function getAblockById($ablockId) {
        $ablock = AExtendblockEntity::where('id', $ablockId)->first();

        return $ablock;
    }

    public static function getShowFieldElement($ablockId, $showField, $elementId, $full = false) {
        $ablock = AExtendblockEntity::where('id', $ablockId)->first();

        $element = DB::table($ablock->table_name)->where('id', $elementId)->first();
        if (!$element) {
            return null; 
        }

        if ($full) {
            return array(
                'element_id' => $element->id,
                'element_value' => $element->$showField,
                'ablock_id' => $ablockId
            );
        }

        return $element->$showField;
    }

    public static function getListFile($path) {
        $arRes = array_diff(scandir($path), array('.', '..'));
        return $arRes;
    }

    public static function getInfoUser($userId) {
        $user_meta = AExtendblockUserMeta::where('user_id', $userId)->first();

        $file = AExtendblockFile::findOrFail($user_meta->photo);

        return $file;
    }

    // register action after add element
    public static function addActionAfterAddElement($calback, $sort = 1, $params = array()) {
        $arActionAfterAddElement[] = array(
            'CALLBACK' => $calback,
            'SORT' => $sort,
            'PARAMS' => $params,
        );
    }

    // update element of ablock
    public static function updateElement($ablockId, $elementId, $arParams) {
        $ablock = AExtendblockEntity::where("id", $ablockId)->first();
        $arUserField = AExtendblockUserField::where("entity_id", 'A_BLOCK_' . $ablockId)->orderBy('sort', 'asc')->get();

        $row = array();
        foreach ($arUserField as $userField) {
            $field = $userField->field_name;

            if (!in_array($field, array_keys($arParams))) {
                continue;
            }

            // check field is multi
            if ($userField->multiple == "Y") {
                $row[strtolower($field)] = null;
                continue;
            }

            $row[strtolower($field)] = $arParams[$field];
        }

        DB::table($ablock->table_name)->where('id', $elementId)->update($row);
    }

    public static function addElement($ablockId, $arParams) {
        $ablock = AExtendblockEntity::where("id", $ablockId)->first();
        $arUserField = AExtendblockUserField::where("entity_id", 'A_BLOCK_' . $ablockId)->orderBy('sort', 'asc')->get();

        $row = array();
        foreach ($arUserField as $userField) {
            $field = $userField->field_name;

            if (!in_array($field, array_keys($arParams))) {
                continue;
            }

            // check field is multi
            if ($userField->multiple == "Y") {
                $row[strtolower($field)] = null;
                continue;
            }

            $row[strtolower($field)] = $arParams[$field];
        }

        DB::table($ablock->table_name)->insert($row);
    }

    // get element from ablock by ablockid and elementid
    public static function getInfoElement($ablockId, $elementId) {
        // get current lang
        $curLang = app()->getLocale();

        $arResults = array('ABLOCK_ID' => $ablockId, "ELEMENT_ID" => $elementId);
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

        $item = DB::table($arResults['BLOCK']->table_name)->where("id", $elementId)->first();
        $arResults['ELEMENT'] = $item;

        /*
        $users = DB::table('users')
            ->select("users.id", "users.name", "a_extendblock_user_meta.photo")
            ->leftJoin('a_extendblock_user_meta', 'users.id', '=', 'a_extendblock_user_meta.user_id')
            ->limit(self::LIMIT)
            ->get();

        foreach ($users as $user) {
            if (!empty($user->photo)) {
                $file = AExtendblockFile::where('id', $user->photo)->first();
            }

            $data = [
                'id' => $user->id,
                'name' => $user->name,
                'photo' => null
            ];

            if (isset($file) && $file) {
                $data['photo'] = !empty($user->photo) ? $file->path : null;
            }

            $arResults['USERS'][] = (object) $data;
        }
        */

        foreach ($arResults['USER_FIELD'] as $userField) {
            $key = $userField["field_name"];
            $arResults['ITEM'][$key] = array(
                'value' => '',
                'user_type_id' => $userField["user_type_id"],
            );

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
                            $file['is_image'] = $is_image;
                            $file['extension'] = $extension;
                            $file['field_name'] = $userField['field_name'];
                            $file['ablock_id'] = $arResults['BLOCK']->id;
                        }

                        $list_image[] = $file;
                    }

                    $arResults['ITEM'][$key]['value'] = $list_image;
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

                    $arResults['ITEM'][$key]['value'] = $listLinkToElement;
                    continue;
                }

                $arResults['ITEM'][$key]['value'] = $data;
                continue;
            }

            // check field is file
            if ($userField["user_type_id"] == "file") {
                $file = AExtendblockFile::where('id', $item->$keyDB)->first();

                if ($file) {
                    $extension = pathinfo($file->name, PATHINFO_EXTENSION);
                    $is_image = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);

                    $file = $file->toArray();
                    $file['is_image'] = $is_image;
                    $file['extension'] = $extension;
                    $file['field_name'] = $userField['field_name'];
                    $file['ablock_id'] = $arResults['BLOCK']->id;
                    $arResults['ITEM'][$key]['value'] = $file;
                }

                continue;
            }

            // check is link to user
            if (($userField["user_type_id"] == 'link_to_user') && isset($item->$keyDB) && !empty($item->$keyDB)) {
                $user = AExtendblockUsers::where('id', $item->$keyDB)->first();
                if ($user) {
                    $user = $user->toArray();
                    $arResults['ITEM'][$key]['value'] = $user;
                }

                continue;
            }

            // check is link to element
            if ($userField["user_type_id"] == 'link_to_element') {
                $settingField = json_decode($userField['settings'], true);
                if (isset($settingField['show_field'])) {
                    $arResults['ITEM'][$key]['value'] = UtilityController::getShowFieldElement($settingField['link_to_ablock'], strtolower($settingField['show_field']), $item->$keyDB, true);
                }

                continue;
            }

            if (isset($item->$keyDB)) {
                $arResults['ITEM'][$key]['value'] = $item->$keyDB;
            }
        }

        $arResults['USERS'] = AExtendblockUserController::getList();
        $arResults['ROLES'] = AExtendblockUserRoleController::getList();
        $arResults['TASK'] = ATaskController::getListByModuleID("a_extend_block");
        $arResults['RIGHT'] = AExtendblockElementRightsController::getlist($ablockId, $elementId);

        return $arResults;
    }
}