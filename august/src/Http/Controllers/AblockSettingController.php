<?php

namespace Package\August\Http\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Package\August\Models\AExtendblockSetting;
use Package\August\Models\AExtendblockFile;
use Package\August\Http\Controllers\AExtendblockFileController;
use Carbon\Carbon;

class AblockSettingController extends BaseController {
    public static function getSettingSite() {
        $res = AExtendblockSetting::get();
        $arResults = array(
            "site_title" => 'August Site',
            "site_logo_path" => '/assets-august/images/logo-light.png',
            "site_icon_path" => '/assets-august/images/logo-light.png',
        );

        foreach ($res as $key => $value) {
            if ($value->setting_name == 'site_icon') {
                $arResults['site_icon_path'] = asset('storage/' . AExtendblockFileController::getPathById ($value->setting_value));
            }

            if ($value->setting_name == 'site_logo') {
                $arResults['site_logo_path'] = asset('storage/' . AExtendblockFileController::getPathById ($value->setting_value));
            }

            $arResults[$value->setting_name] = $value->setting_value;
        }

        // dd($arResults);

        return $arResults;
    }

    public function index() {
        $arResults = $this->getSettingSite();

        // dd($arResults);
        return view('August::setting.index', ['arResults' => $arResults]);
    }

    public function store(Request $request) {
        $inputs = $request->input();
        // dd($inputs);

        $year = Carbon::now()->year;
        $month = Carbon::now()->format('m');
        $path = "$year/$month";


        if ($request->hasFile('site_icon')) {
            try {
                $file = $request->file('site_icon');

                $fileStore = time().'.'.$file->getClientOriginalExtension();
                $path_db = $file->storeAs($path, $fileStore, 'public');

                $fileId = AExtendblockFile::create(array(
                    "name" => $file->getClientOriginalName(),
                    "path" => $path_db,
                ))->id;

                $inputs['site_icon'] = $fileId;
            } catch (\Illuminate\Database\QueryException $exception) {
                return back()->withErrors(['exception' => trans('August::messages.exception')]);
            }
        }

        if ($request->hasFile('site_logo')) {
            try {
                $file = $request->file('site_logo');

                $fileStore = time().'.'.$file->getClientOriginalExtension();
                $path_db = $file->storeAs($path, $fileStore, 'public');

                $fileId = AExtendblockFile::create(array(
                    "name" => $file->getClientOriginalName(),
                    "path" => $path_db,
                ))->id;

                $inputs['site_logo'] = $fileId;
            } catch (\Illuminate\Database\QueryException $exception) {
                return back()->withErrors(['exception' => trans('August::messages.exception')]);
            }
        }

        foreach ($inputs as $key => $value) {
            if (in_array($key, array('_token', 'btn_action'))) {
                continue;
            }

            AExtendblockSetting::where('setting_name', $key)->delete();
            AExtendblockSetting::create(array(
                "setting_name" => $key,
                "setting_value" => $value,
            ))->id;
        }

        return redirect()->route('august.setting.index');
    }
}