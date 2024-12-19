<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Module;
use App\Models\Blog;
use App\Models\Pages;
use App\Models\News;
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
    $data = Module::latest()->paginate(5);
    return view('module.index', compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
}

public function create(): View
{
    $categories = [
        'Blog' => Blog::pluck('name', 'id')->all(),
        'News' => News::pluck('name', 'id')->all(),
        'Pages' => Pages::pluck('title', 'id')->all(),
    ];
    $permissions = Permission::all();
    return view('module.create', compact('categories', 'permissions'));
}

public function store(Request $request): RedirectResponse
{
    $data = [
        'Title' => $request->Title,
        'parent_id' => $request->parent_id ?? 0,
        'create_date' => $request->created_at ?? now(),
        'update_date' => $request->updated_at ?? now(),
    ];
    Module::create($data);
    return redirect()->route('module.index')
        ->with('success', 'Module created successfully.');
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
    // dd($request);
    foreach ($request->module_id as $key => $moduleId) {
        if (!empty($request->name[$key])) {
            Permission::create([
                'module_id' => $moduleId,
                'name' => $request->name[$key],
            ]);
        }
    }

    return response()->json(['message' => 'Permissions saved successfully!']);
}

public function getPermissions($id)
{
    $permissions = Permission::where('module_id', $id)->get(); 
    return response()->json(['permissions' => $permissions]);
}

}