<?php

namespace Package\August\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Package\August\Models\AExtendblockFilterMode;

class AExtendblockFilterModeController extends BaseController { 
    public function getRecordById(Request $request) {
        $result = AExtendblockFilterMode::where('user_id', $request->user_id)->where('eb_id', $request->eb_id)->get();
        return $result;
    }

    public function store(Request $request) {
        $inputs = $request->input();

        if (isset($inputs['id']) && (intval($inputs['id']) == 0)) {
            AExtendblockFilterMode::create(array(
                "eb_id" => $inputs['eb_id'],
                "user_id" => $inputs['user_id'],
                "filter_mode" => $inputs['filter_mode'],
            ));
        } else {
            $filter_mode = AExtendblockFilterMode::where('id', $inputs['id'])->first();
            $filter_mode->eb_id = $inputs['eb_id'];
            $filter_mode->user_id = $inputs['user_id'];
            $filter_mode->filter_mode = $inputs['filter_mode'];
            $filter_mode->save();
        }
    }

    public function delete(Request $request) {
        $result = AExtendblockFilterMode::where('user_id', $request->user_id)->where('eb_id', $request->eb_id)->get();

        if ($result) {
            $result->delete();
        }
    }
}