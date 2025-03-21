<?php
    
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\RedirectResponse;
use App\Models\Module;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
    
class RoleController extends Controller
{

function __construct()
{
     $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
     $this->middleware('permission:role-create', ['only' => ['create','store']]);
     $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
     $this->middleware('permission:role-delete', ['only' => ['destroy']]);
}

public function index(Request $request): View
{
    $roles = Role::orderBy('id','DESC')->paginate(5);
   
    return view('backend.roles.index',compact('roles'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
}

public function create(): View
{
    $permission = Permission::get();
    return view('backend.roles.create',compact('permission'));
}

public function store(Request $request): RedirectResponse
{
    $this->validate($request, [
        'name' => 'required|unique:roles,name',
        'permission' => 'required',
    ]);
    $permissionsID = array_map(
        function($value) { return (int)$value; },
        $request->input('permission')
    );

    $role = Role::create(['name' => $request->input('name')]);
    $role->syncPermissions($permissionsID);

    return redirect()->route('roles.index')
                    ->with('success','Role created successfully');
}
public function show($id): View
{
    $role = Role::find($id);
    $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
        ->where("role_has_permissions.role_id",$id)
        ->get();

    return view('backend.roles.show',compact('role','rolePermissions'));
}
public function edit(Request $request, $id)
{
    $role = Role::find($id);
    $modulesQuery = Module::with(['childmodule.permission'])
        ->where('parent_id', 0);

    // Check if it's an AJAX request
    if ($request->ajax()) {
        if ($request->has('module_title') && !empty($request->module_title)) {
            $modulesQuery->where('Title', 'like', '%' . $request->module_title . '%');
        }

        $filteredModules = $modulesQuery->get();

        return response()->json([
            'success' => true,
            'modules' => $filteredModules,
        ]);
    }

    $modules = $modulesQuery->get();
    $rolePermissions = DB::table("role_has_permissions")
        ->where("role_id", $id)
        ->pluck('permission_id')
        ->toArray();

    return view('backend.roles.edit', compact('role', 'modules', 'rolePermissions'));
}


public function update(Request $request, $id): RedirectResponse
{
    $this->validate($request, [
        'name' => 'required',
        'permission' => 'required',
    ]);

    $role = Role::find($id);
    $role->name = $request->input('name');
    $role->save();
    $permissionsID = array_map(
        function($value) { return (int)$value; },
        $request->input('permission')
    );

    $role->syncPermissions($permissionsID);

    return redirect()->route('roles.index')
                    ->with('success','Role updated successfully');
}

public function destroy($id): RedirectResponse
{
    DB::table("roles")->where('id',$id)->delete();
    return redirect()->route('roles.index')
                    ->with('success','Role deleted successfully');
}
}
