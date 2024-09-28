<?php

namespace Package\August\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Package\August\Models\AExtendblockLang;

class AExtendblockLangController extends BaseController {
    public function index() {
        $arResults['ITEMS'] = AExtendblockLang::get(); 
        return view('August::lang.index', ['arResults' => $arResults]);
    }

    public function add() {
        $arParams = array('ID' => 0);
        return view('August::lang.add', ['arParams' => $arParams]);
    }

    public function copy(string $langId) {
        $ablockLang = AExtendblockLang::where('id', $langId)->first();
        $arParams = array(
            'ID' => 0,
            'ABLOCK_LANG' => $ablockLang
        );
        return view('August::lang.add', ['arParams' => $arParams]);
    }

    public function edit(string $langId) {
        $ablockLang = AExtendblockLang::where('id', $langId)->first();
        $arParams = array(
            'ID' => $langId,
            'ABLOCK_LANG' => $ablockLang
        );
        return view('August::lang.add', ['arParams' => $arParams]);
    }

    public function store(Request $request) {
        //validate
        $messages = [
            'lang_id.required' => trans('August::validation.lang_id.required'),
            'flag.required' => trans('August::validation.flag.required'),
            'title.required' => trans('August::validation.title.required'),
        ];

        $request->validate([
            'lang_id' => 'required',
            'flag' => 'required',
            'title' => 'required',
        ], $messages);
        
        $inputs = $request->input();

        if(isset($inputs['id']) && (intval($inputs['id']) == 0)) {
            $ablock_lang_id = AExtendblockLang::where('lang_id', $inputs['lang_id'])->first();
            if(!empty($ablock_lang_id)) {
                return back()->withErrors(['lang_id.exist' => trans('August::validation.lang_id.exist')]);
            } else {
                try {
                    $langId = AExtendblockLang::create(array(
                        "lang_id" => $inputs['lang_id'],
                        "flag" => $inputs['flag'],
                        "title" => $inputs['title'],
                    ))->id;
                    if (isset($inputs['btn_action']) && ($inputs['btn_action'] == 'apply')) {
                        return redirect()->route('august.lang.edit', ['id_lang' => $langId]);
                    } else {
                        return redirect()->route('august.lang.index');
                    }
                } catch (\Illuminate\Database\QueryException $exception) {
                    return back()->withErrors(['exception' => trans('August::messages.exception')]);
                }
            }
        } else {
            $lang = AExtendblockLang::where('id', $inputs['id'])->first();
            $lang->lang_id = $inputs['lang_id'];
            $lang->flag = $inputs['flag'];
            $lang->title = $inputs['title'];
            $lang->save();

            if (isset($inputs['btn_action']) && ($inputs['btn_action'] == 'apply')) {
                return redirect()->route('august.lang.edit', ['id_lang' => $inputs['id']]);
            } else {
                return redirect()->route('august.lang.index');
            }
        }
    }

    public function delete($langId) {
        $lang = AExtendblockLang::findOrFail($langId);

        if(!empty($lang)) {
            $result = $lang->delete();
            if($result) {
                return redirect()->back();
            }
        }
    }
}