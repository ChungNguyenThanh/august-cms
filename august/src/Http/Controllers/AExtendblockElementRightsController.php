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
use Package\August\Models\AExtendblockElementRights;
use Package\August\Models\AExtendblockUserRole;
use Package\August\Models\AExtendblockUsers;

use Package\August\Http\Controllers\ATaskController;

class AExtendblockElementRightsController extends BaseController { 
    public static function getList($ablockId, $elementId) {
    	$arResult = array();

        $arTask = ATaskController::getListByModuleID("a_extend_block");

        $arRights = DB::table("a_extendblock_element_rights as r")
        ->select("r.*", "r.id as id_right", "t.*", "u.*")
        ->join('a_task as t', 'r.task_id', '=', 't.id')
        ->join('a_user_access as u', 'r.access_code', '=', 'u.access_code')
        ->where(array('r.eb_id' => $ablockId, 'r.element_id' => $elementId))
        ->get();

        // dd($arRights);
        $arUserId = array();
        $arGroupId = array();

        foreach ($arRights as $key => $value) {
            $arResult[$value->id_right] = array(
                'eb_id' => $value->eb_id,
                'element_id' => $value->element_id,
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

        // dd($arResult);

        return $arResult;
    }
    
    public static function getNotAccessByUserId($ablockId, $userId) {
        $arResult = array();

        $arRights = DB::table("a_extendblock_element_rights as r")
        ->select("r.*", "r.id as id_right", "t.*", "u.*")
        ->join('a_task as t', 'r.task_id', '=', 't.id')
        ->join('a_user_access as u', 'r.access_code', '=', 'u.access_code')
        ->where(array('r.eb_id' => $ablockId, 'u.user_id' => $userId))
        ->get();

        foreach ($arRights as $key => $value) {
            if ($value->letter == 'D') {
                $arResult[] = $value->element_id;
            }
        }

        // dd($arRights);

        return $arResult;
    }
}