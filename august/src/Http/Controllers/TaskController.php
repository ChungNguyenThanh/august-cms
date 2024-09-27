<?php

namespace Package\August\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Package\August\Http\Controllers\UtilityController;

class TaskController extends BaseController {
    public function index(Request $request) {
        return view('August::templates.default.index');
    }
}