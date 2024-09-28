<?php

namespace Package\August\Http\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Package\August\Models\AExtendblockEntityRights;
use Package\August\Models\AExtendblockUserRole;
use Package\August\Models\AExtendblockUsers;

use Package\August\Http\Controllers\ATaskController;

class AExtendblockEntityRightsController extends BaseController { 
    public static function getList($ablockId) {
        $arResult = array();

        $arTask = ATaskController::getListByModuleID("a_extend_block");

        $arRights = DB::table("a_extendblock_entity_rights as r")
        ->select("r.*", "r.id as id_right", "t.*", "u.*")
        ->join('a_task as t', 'r.task_id', '=', 't.id')
        ->join('a_user_access as u', 'r.access_code', '=', 'u.access_code')
        ->where(array('r.eb_id' => $ablockId))
        ->get();

        // dd($arRights);

        $arUserId = array();
        $arGroupId = array();

        foreach ($arRights as $key => $value) {
            $arResult[$value->id_right] = array(
                'eb_id' => $value->eb_id,
                'access_code' => $value->access_code,
                'letter' => $value->letter,
                'module_id' => $value->module_id,
                'provider_id' => $value->provider_id,
                'user_id' => $value->user_id,
                'a_task_name' => $arTask[$value->letter],
            );

            if ($value->provider_id == 'user') {
                $arUserId[] = $value->user_id;
            } else {
                $arGroupId[] = $value->user_id;
            }
        }

        $objUser = AExtendblockUsers::whereIn('id', $arUserId)->get();
        $objGroup = AExtendblockUserRole::whereIn('id', $arGroupId)->get();

        $arUser = array();
        foreach ($objUser as $key => $value) {
            $arUser[$value->id] = array(
                "name" => $value->name
            );
        }

        $arGroup = array();
        foreach ($objGroup as $key => $value) {
            $arGroup[$value->id] = array(
                "name" => $value->name
            );
        }

        foreach ($arResult as $key => $value) {
            if ($value['provider_id'] == 'user') {
                $arResult[$key]['obj_name'] = $arUser[$value['user_id']]['name'];
            } else {
                $arResult[$key]['obj_name'] = $arGroup[$value['user_id']]['name'];
            }
        }

        return $arResult;
    }

    // order permission
    public static function orderPermission($letter) {
        $order = array(
            "D" => 0,
            "S" => 1,
            "R" => 2,
            "E" => 3,
            "T" => 4,
            "U" => 5,
            "W" => 6,
            "X" => 7,
            "N" => 8
        );

        if (isset($order[$letter])) {
            return $order[$letter];
        }

        return 100;
    }

    // return action access
    public static function actionAccess($letter) {
        $arActionAccess = array(
            'ADD_ELEMENT' => 'N',
            'COPY_ELEMENT' => 'N',
            'VIEW_ELEMENT' => 'N',
            'EDIT_ELEMENT' => 'N',
            'DELETE_ELEMENT' => 'N',
            'VIEW_LIST_ELEMENT' => 'N',
            'RUN_VIEW_LOG_BIZPRO' => 'N',
            'EDIT_STATUS_BIZPRO' => 'N',
            'EDIT_BLOCK_SETTING' => 'N',
            'EDIT_ELEMENT_SETTING' => 'N',
            'EDIT_BLOCK_RIGHT' => 'N',
            'CONFIG_BIZPRO' => 'N',
            'CONFIG_REPORT' => 'N',
            'IMPORT_EXCEL' => 'N',
            'EXPORT_EXCEL' => 'N',
        );

        if ($letter == 'S' || $letter == 'R') {
            $arActionAccess['VIEW_LIST_ELEMENT'] = 'Y';
            $arActionAccess['EXPORT_EXCEL'] = 'Y';
            $arActionAccess['VIEW_ELEMENT'] = 'Y';
        } elseif ($letter == 'E') {
            $arActionAccess['ADD_ELEMENT'] = 'Y';
            $arActionAccess['IMPORT_EXCEL'] = 'Y';
            $arActionAccess['EXPORT_EXCEL'] = 'Y';
        } elseif ($letter == 'T') {
            $arActionAccess['ADD_ELEMENT'] = 'Y';
            $arActionAccess['COPY_ELEMENT'] = 'Y';
            $arActionAccess['VIEW_LIST_ELEMENT'] = 'Y';
            $arActionAccess['IMPORT_EXCEL'] = 'Y';
            $arActionAccess['EXPORT_EXCEL'] = 'Y';
            $arActionAccess['VIEW_ELEMENT'] = 'Y';
        } elseif ($letter == 'U') {
            $arActionAccess['ADD_ELEMENT'] = 'Y';
            $arActionAccess['COPY_ELEMENT'] = 'Y';
            $arActionAccess['VIEW_LIST_ELEMENT'] = 'Y';
            $arActionAccess['RUN_VIEW_LOG_BIZPRO'] = 'Y';
            $arActionAccess['IMPORT_EXCEL'] = 'Y';
            $arActionAccess['EXPORT_EXCEL'] = 'Y';
            $arActionAccess['VIEW_ELEMENT'] = 'Y';
            $arActionAccess['EDIT_ELEMENT'] = 'Y';
            $arActionAccess['DELETE_ELEMENT'] = 'Y';
        } elseif ($letter == 'W') {
            $arActionAccess['ADD_ELEMENT'] = 'Y';
            $arActionAccess['COPY_ELEMENT'] = 'Y';
            $arActionAccess['VIEW_LIST_ELEMENT'] = 'Y';
            $arActionAccess['RUN_VIEW_LOG_BIZPRO'] = 'Y';
            $arActionAccess['EDIT_STATUS_BIZPRO'] = 'Y';
            $arActionAccess['IMPORT_EXCEL'] = 'Y';
            $arActionAccess['EXPORT_EXCEL'] = 'Y';
            $arActionAccess['VIEW_ELEMENT'] = 'Y';
            $arActionAccess['EDIT_ELEMENT'] = 'Y';
            $arActionAccess['DELETE_ELEMENT'] = 'Y';
        } elseif ($letter == 'X') {
            $arActionAccess['ADD_ELEMENT'] = 'Y';
            $arActionAccess['COPY_ELEMENT'] = 'Y';
            $arActionAccess['VIEW_LIST_ELEMENT'] = 'Y';
            $arActionAccess['RUN_VIEW_LOG_BIZPRO'] = 'Y';
            $arActionAccess['EDIT_STATUS_BIZPRO'] = 'Y';
            $arActionAccess['EDIT_BLOCK_SETTING'] = 'Y';
            $arActionAccess['EDIT_BLOCK_RIGHT'] = 'Y';
            $arActionAccess['CONFIG_BIZPRO'] = 'Y';
            $arActionAccess['CONFIG_REPORT'] = 'Y';
            $arActionAccess['IMPORT_EXCEL'] = 'Y';
            $arActionAccess['EXPORT_EXCEL'] = 'Y';
            $arActionAccess['VIEW_ELEMENT'] = 'Y';
            $arActionAccess['EDIT_ELEMENT'] = 'Y';
            $arActionAccess['DELETE_ELEMENT'] = 'Y';
            $arActionAccess['EDIT_ELEMENT_SETTING'] = 'Y';
        }

        return $arActionAccess;
    }

    // Get permission into ablock
    // order role: D, S, R, E, T, U, W, X
    public static function getAccess($ablockId, $userId) {
        $arTask = ATaskController::getListByModuleID("a_extend_block");

        // get rights by user
        $arRights = DB::table("a_extendblock_entity_rights as r")
        ->select("r.*", "r.id as id_right", "t.*", "u.*")
        ->join('a_task as t', 'r.task_id', '=', 't.id')
        ->join('a_user_access as u', 'r.access_code', '=', 'u.access_code')
        ->where(array('r.eb_id' => $ablockId, 'u.user_id' => $userId, "provider_id" => "user"))
        ->get();

        $letter = 'N';
        foreach ($arRights as $key => $value) {
            if (self::orderPermission($letter) > self::orderPermission($value->letter) && self::orderPermission($value->letter) != -1) {
                $letter = $value->letter;
            }
        }

        // get right by group
        if ($letter == 'N') {
            $arRole = DB::table("a_extendblock_user_role_relation")->where("user_id", $userId)->get();
            $arRoleId = array();

            foreach ($arRole as $key => $value) {
                $arRoleId[] = $value->role_id;
            }

            if (!empty($arRoleId)) {
                $arRights = DB::table("a_extendblock_entity_rights as r")
                ->select("r.*", "r.id as id_right", "t.*", "u.*")
                ->join('a_task as t', 'r.task_id', '=', 't.id')
                ->join('a_user_access as u', 'r.access_code', '=', 'u.access_code')
                ->where(array('r.eb_id' => $ablockId, "provider_id" => "group"))
                ->whereIn('u.user_id', $arRoleId)
                ->get();

                foreach ($arRights as $key => $value) {
                    $arResult[$value->id_right] = array(
                        'eb_id' => $value->eb_id,
                        'access_code' => $value->access_code,
                        'letter' => $value->letter,
                        'module_id' => $value->module_id,
                        'provider_id' => $value->provider_id,
                        'user_id' => $value->user_id,
                        'a_task_name' => $arTask[$value->letter],
                    );
                }
            }
        }

        if ($letter == 'N') {
            $letter = 'D';
        }

        return $letter;
    }
}