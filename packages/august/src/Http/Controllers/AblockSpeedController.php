<?php

namespace Package\August\Http\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AblockSpeedController extends BaseController { 
    public function index() {
        $arResults = array();
        return view('August::templates.speed.index', ['arResults' => $arResults]);
    }
}