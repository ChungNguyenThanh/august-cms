<?php

namespace Package\August\Http\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Package\August\Models\ATask;

class ATaskController extends BaseController { 
    public static function getListByModuleID($moduleId) {
        $res = ATask::where('module_id', $moduleId)->get();
        $arTask = array();
        foreach ($res as $key => $value) {
            $arTask[$value['letter']] = trans('August::atask.'.$value['name']);
        }

        return $arTask;
    }
}