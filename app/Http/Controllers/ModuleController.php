<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Module;
use App\Models\Blog;
use App\Models\Pages;
use App\Models\News;
use App\Models\User;

// use App\Models\Permission;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;


class ModuleController extends Controller
{
    
public function index(Request $request): View
{
    $formattedDate = format_date('2024-12-24');
    $data = Module::latest()->paginate(5);
    return view('module.index', compact('data','formattedDate'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
}

public function create(): View
{
    $categories = [
        'Blog' => Blog::pluck('name', 'id')->all(),
        'News' => News::pluck('name', 'id')->all(),
        'Pages' => Pages::pluck('title', 'id')->all(),
        'User' => User::pluck('name', 'id')->all(),

    ];
    $permissions = Permission::all();
    return view('module.create', compact('categories', 'permissions'));
}

public function store(Request $request)
{
    $request->validate([
        'parent_name' => 'required|string',
        'Title' => 'required|string',
    ]);

   
    $parentName = $request->input('parent_name');

   
    $parentId = null;

    switch ($parentName) {
        case 'Blog':
            $parentId = module::where('Title', 'Blog')->pluck('id')->first();

            break;

        case 'News':
            $parentId = module::where('Title', 'News')->pluck('id')->first();
            break;

        case 'Pages':
            $parentId = module::where('Title', 'Pages')->pluck('id')->first();

            break;
            case 'User':
                $parentId = module::where('Title', 'Pages')->pluck('id')->first();
    
                break;

        default:
            $parentId = null; 
            break;
    }

 
    $parentId = $parentId ?? 0;

  
    Module::create([
        'Title' => $request->input('Title'),
        'parent_id' => $parentId,
    ]);

    return redirect()->route('module.index')->with('success', 'Module created successfully.');
}



public function show($id): View
{
    $module = Module::findOrFail($id);
    return view('module.show', compact('module'));
}

public function edit($id): View
{
    $module = Module::findOrFail($id);
    return view('module.edit', compact('module'));
}

public function update(Request $request, $id): RedirectResponse
{
    $module = Module::findOrFail($id);
    $module->update($request->all());
    return redirect()->route('module.index')
        ->with('success', 'Module updated successfully.');
}

public function destroy($id): RedirectResponse
{
    Module::findOrFail($id)->delete();
    return redirect()->route('module.index')
        ->with('success', 'Module deleted successfully.');
}

//
public function savePermissions(Request $request)
{
    foreach ($request->module_id as $key => $moduleId) {
        if (!empty($request->name[$key])) {
         
            Permission::updateOrCreate(
                ['module_id' => $moduleId, 'name' => $request->name[$key]], 
                ['name' => $request->name[$key]] 
            );
        }
    }

    return response()->json(['message' => 'Permissions saved or updated successfully!']);
}


public function getPermissions($id)
{
    $permissions = Permission::where('module_id', $id)->get(); 
    return response()->json(['permissions' => $permissions]);
}

public function destroyPermission($id)
{
    try {
      
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return response()->json(['message' => 'Permission deleted successfully.']);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error deleting permission.'], 500);
    }
}


}