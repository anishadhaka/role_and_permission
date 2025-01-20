<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\module;

use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class MenuController extends Controller
{
   
public function index(Request $request):view
{
    {
        $data = Menu::latest()->paginate(5);
  
        return view('backend.menu.index',compact('data'));
    }
}

public function create()
{
    return view('backend.menu.create');
}
public function store(Request $request)
{
  
    $validated = $request->validate([
        'category' => 'required|string|max:255',
        'permission' => 'required|string|max:255',
    ]);

    $data = [
        'category' => $validated['category'],
        'permission' => $validated['permission'],
    ];
    Menu::create($data);
    return redirect()->route('menu.index')->with('success', 'Menu created successfully!');
}

public function show(Menu $menu)
{
    //
}

public function edit($id)
{
    $menu = Menu::where('id',$id)->firstOrFail();
    return view('backend.menu.edit',compact('menu'));
}

public function update(Request $request, $id): RedirectResponse
{
  
    $validated = $request->validate([
        'category' => 'required|string|max:255',
        'permission' => 'required|string|max:255',
    ]);

    $menu = Menu::find($id);
    if (!$menu) {
        return redirect()->route('menu.index')->with('error', 'Menu not found!');
    }

    $menu->update([
        'category' => $validated['category'],
        'permission' => $validated['permission'],
    ]);

    return redirect()->route('menu.index')->with('success', 'Menu updated successfully!');
}


public function destroy($id)
{
    Menu::where('id',$id)->firstOrFail()->delete();
    return redirect()->route('menu.index')
                    ->with('success','User deleted successfully');
}

public function showmenu($id)
{
    $menu = Menu::whereid($id)->first();
    $finalmenu_output = json_decode($menu, true);
    // dd($finalmenu_output);
    if ($finalmenu_output ) {
        return view('backend.menu.menu', compact('finalmenu_output'));
    } else {
        return redirect()->route('menulist')->with('error', 'Menu not found');
   }
    
}

function updatejsondata(Request $request)
{
    $blog = Menu::find($request->id);

    if ($blog) {
        module::truncate();

        $jsonDataArray = json_decode($request->input('json_output'), true);

        if (is_array($jsonDataArray)) {
            function saveModule($data, $parentId = 0)
            {
                foreach ($data as $item) {
                    $module = new module();
                    $module->Title = $item['text'] ?? 'Unnamed Module';
                    $module->parent_id = $parentId;
                    
                    $module->created_at = now();
                    $module->updated_at = now();
                    $module->save();

                    if (!empty($item['children'])) {
                        saveModule($item['children'], $module->id);
                    }
                }
            }

            saveModule($jsonDataArray);
        }

        $blog->json_output = json_encode($jsonDataArray);

        if ($blog->save()) {
            return redirect()->route('menu.index')->with('success', 'Blog and modules updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update the blog.');
        }
    } else {
        return redirect()->route('menu')->with('error', 'Blog not found.');
  }
}
}
