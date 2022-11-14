<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MenuLink;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    function index()
    {
        $menus = MenuLink::paginate(10);
        return view('admin-views.menu.list', compact('menus'));
    }

    public function navbar(Request $request)
    {
        if ($request->post()) {
            // add new menu.
            MenuLink::insert([
                'menu_type'     =>  $request->menu_type,
                'menu_link'     =>  $request->menu_link,
                'menu_column'   =>  $request->menu_column ?? NULL,
                'menu_title'    =>  $request->menu_title
            ]);
            Toastr::success("Menu created successfully");
            return redirect(route('admin.menu.list'));
        }
        return view('admin-views.menu.add');
    }

    public function edit(Request $request, $id)
    {
        $menu = MenuLink::find($id);
        if ($request->post()) {
            // add new menu.
            $menu = MenuLink::find($id);
            $menu->menu_type     =  $request->menu_type;
            $menu->menu_link     =  $request->menu_link;
            $menu->menu_column   =  $request->menu_column ?? NULL;
            $menu->menu_title    =  $request->menu_title;
            $menu->save();
            Toastr::success("Menu created successfully");
            return redirect(route('admin.menu.list'));
        }
        return view('admin-views.menu.edit', compact('menu'));
    }

    public function destroy($id)
    {
        if(MenuLink::destroy($id)){
            Toastr::success("Menu deleted successfully");
            return back();
        }
    }
}
