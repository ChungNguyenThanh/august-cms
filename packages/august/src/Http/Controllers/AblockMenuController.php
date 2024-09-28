<?php

namespace Package\August\Http\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Package\August\Models\AExtendblockMenu;
use Package\August\Models\AExtendblockMenuGroup;

class AblockMenuController extends BaseController { 
    public function index(Request $request) {
        $inputs = $request->input();
        $query = \DB::table('a_extendblock_menu')
            ->select("a_extendblock_menu.*", "a_extendblock_menu_group.name as name_group")
            ->leftJoin('a_extendblock_menu_group', 'a_extendblock_menu.menu_group', '=', 'a_extendblock_menu_group.code');

        if ($request->has("groupmenu")) {
            $query->where("menu_group", $request->groupmenu);
        }
        $arResults['ITEMS'] = $query->get();

        $arResults['GROUP'] = AExtendblockMenuGroup::get();

        return view('August::ablockmenu.index', ['arResults' => $arResults]);
    }

    public function add() {
        $arParams = array(
            "ID" => 0,
            "PARENT_MENU" => AExtendblockMenu::where('parent_item_menu',0)->get(),
            'GROUP' => AExtendblockMenuGroup::get()
        );
        return view('August::ablockmenu.add', ['arParams' => $arParams]);
    }

    public function edit($menuId) {
        $ablockMenu = AExtendblockMenu::where('id', $menuId)->first();
        $arParams = array(
            "ID" => $ablockMenu->id,
            "MENU" => $ablockMenu,
            "PARENT_MENU" => AExtendblockMenu::where('parent_item_menu', 0)->get(),
            'GROUP' => AExtendblockMenuGroup::get()
        );
        return view('August::ablockmenu.add', ['arParams' => $arParams]);
    }

    public function store(Request $request) {

        $inputs = $request->input();

        if (isset($inputs['id']) && (intval($inputs['id']) == 0)) {
            try {
                $menuId = AExtendblockMenu::create(array(
                    "menu_title" => $inputs['menu_title'],
                    "menu_link" => $inputs['menu_link'],
                    "parent_item_menu" => $inputs['parent_item_menu'],
                    "menu_group" => $inputs['menu_group'],
                ))->id;

                if (isset($inputs['btn_action']) && ($inputs['btn_action'] == 'apply')) {
                    return redirect()->route('august.menu.edit', ['id_menu' => $menuId]);
                } else {
                    return redirect()->route('august.menu.index');
                }
            } catch (\Illuminate\Database\QueryException $exception) {
                return back()->withErrors(['exception' => $exception->getMessage()]);
            }
        } else {
            $menu = AExtendblockMenu::where('id', $inputs['id'])->first();
            $menu->menu_title = $inputs['menu_title'];
            $menu->menu_group = $inputs['menu_group'];
            $menu->menu_link = $inputs['menu_link'];
            $menu->parent_item_menu = $inputs['parent_item_menu'];
            $menu->save();

            if (isset($inputs['btn_action']) && ($inputs['btn_action'] == 'apply')) {
                return redirect()->route('august.menu.edit', ['id_menu' => $inputs['id']]);
            } else {
                return redirect()->route('august.menu.index');
            }
        }
    }

    public function copy($menuId) {
        $ablockMenu = AExtendblockMenu::where('id', $menuId)->first();
        $arParams = array(
            "ID" => 0,
            "MENU" => $ablockMenu,
            "PARENT_MENU" => AExtendblockMenu::where('parent_item_menu', 0)->get(),
        );
        return view('August::ablockmenu.add', ['arParams' => $arParams]);
    }

    public function delete($menuId) {
        $menu = AExtendblockMenu::findOrFail($menuId);

        $result = $menu->delete();
        if($result) {
            return redirect()->back();
        }
    }

    public function addMenuGroup() {
        $arParams = array("ID" => 0);
        return view('August::ablockmenu.addgroup', ['arParams' => $arParams]);
    }

    public function storeMenuGroup(Request $request) {

        $inputs = $request->input();

        if (isset($inputs['id']) && (intval($inputs['id']) == 0)) {
            try {
                $menuGroupId = AExtendblockMenuGroup::create(array(
                    "name" => $inputs['name'],
                    "code" => $inputs['code'],
                ))->id;

                if (isset($inputs['btn_action']) && ($inputs['btn_action'] == 'apply')) {
                    return redirect()->route('august.menu.edit', ['id_menu' => $menuGroupId]);
                } else {
                    return redirect()->route('august.menu.index');
                }
            } catch (\Illuminate\Database\QueryException $exception) {
                return back()->withErrors(['exception' => $exception->getMessage()]);
            }
        } else {
            $menu = AExtendblockMenuGroup::where('id', $inputs['id'])->first();
            $menu->name = $inputs['name'];
            $menu->code = $inputs['code'];
            $menu->save();

            if (isset($inputs['btn_action']) && ($inputs['btn_action'] == 'apply')) {
                return redirect()->route('august.menu.edit', ['id_menu' => $inputs['id']]);
            } else {
                return redirect()->route('august.menu.index');
            }
        }
    }
}