<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Module;
use App\Models\Blog;
use App\Models\Pages;
use App\Models\News;
use App\Models\User;
use App\Models\Product;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

// use App\Models\Permission;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class ModuleController extends Controller
{
    // function __construct()
    // {
    //      $this->middleware('permission:module-list|module-create|module-edit|module-delete', ['only' => ['index','store']]);
    //      $this->middleware('permission:module-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:module-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:module-delete', ['only' => ['destroy']]);
    // }
public function index(Request $request): View
{
    // dd("fgtf");
    $formattedDate = format_date('2024-12-24');
    $data = Module::latest()->paginate(5);
    return view('backend.module.index', compact('data','formattedDate'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
}

public function create(): View
{
    $categories = [
        'Blog' => Blog::pluck('name', 'id')->all(),
        'News' => News::pluck('name', 'id')->all(),
        'Pages' => Pages::pluck('title', 'id')->all(),
        'User' => User::pluck('name', 'id')->all(),
        'Product' => Product::pluck('name', 'id')->all(),


    ];
    $permissions = Permission::all();
    return view('backend.module.create', compact('categories', 'permissions'));
}
public function showAccess()
{
    
    $modules = module::with(['permission',
    'childmodule' => function ($query){
        $query->whereHas('permission');
    }
    ])->where('parent_id',0)->get();
    

    // dd("$modules");

    // print_r($modules); die;
    return view('backend.module.Access',compact('modules'));
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
                $parentId = module::where('Title', 'User')->pluck('id')->first();
                break;

        case 'Product':
                    $parentId = module::where('Title', 'Product')->pluck('id')->first();
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
    return view('backend.module.show', compact('module'));
}

public function edit($id): View
{
    $module = Module::findOrFail($id);
    return view('backend.module.edit', compact('module'));
}

public function update(Request $request, $id): RedirectResponse
{
    $module = Module::findOrFail($id);
    $module->update($request->all());
    return redirect()->route('module.index')
        ->with('success', 'Module updated successfully.');
}

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



 
public function recycle(Request $request): View
{
    $data = Module::onlyTrashed()
        ->latest()
        ->paginate(5);

    $currentPage = $request->input('page', 1);
    $startIndex = ($currentPage - 1) * 5;

    return view('backend.module.recycle', compact('data'))
        ->with('i', $startIndex);
}

public function destroy($id)
{
    $modulesdata = Module::find($id);

    $menuData = Menu::where('id', 5)->first();
    if (!$menuData) {
        return redirect()->back()->withErrors('Module not found.');
    }
    $modulesdata->deleted_at = now();
    $modulesdata->save();
    $jsonoutput = json_decode($menuData->json_output, true);

    $this->markModuleAsDeleted($jsonoutput, $id);

    $menuData->json_output = json_encode($jsonoutput);
    if ($menuData->save() ) {
        return redirect()->back()->with('success', 'Module delete successful');
    } else {
        return redirect()->back()->withErrors('Module delete unsuccessful');
    }
}

private function markModuleAsDeleted(&$menuItems, $moduleId)
{
    foreach ($menuItems as &$item) {
        if ($item['moduleid'] == $moduleId) {
            $item['deletestatus'] = '0';
            return; 
        }

        if (!empty($item['children'])) {
            foreach ($item['children'] as &$child) {
                if ($child['moduleid'] == $moduleId) {
                    $child['deletestatus'] = '0';
                    return;
                }
            }
        }
    }
}

public function recover($id)
{
     $modulesdata = Module::onlyTrashed()->findOrFail($id);

     $menuData = Menu::where('id', 5)->first();
     if (!$menuData) {
         return redirect()->back()->withErrors('Module not found.');
     }
      $modulesdata->restore();

     $jsonoutput = json_decode($menuData->json_output, true);

     $this->recovermoduledata($jsonoutput, $id);

     $menuData->json_output = json_encode($jsonoutput);
     if ($menuData->save() ) {
         return redirect()->back()->with('success', 'Module delete successful');
     } else {
         return redirect()->back()->withErrors('Module delete unsuccessful');
     }
}

private function recovermoduledata(&$menuItems, $moduleId)
{
    foreach ($menuItems as &$item) {
        if ($item['moduleid'] == $moduleId) {
            $item['deletestatus'] = NULL; 
            return; 
        }

        if (!empty($item['children'])) {
            foreach ($item['children'] as &$child) {
                if ($child['moduleid'] == $moduleId) {
                    $child['deletestatus'] = NULL; 
                    return;
                }
            }
        }
    }
}
// fetch table name from database
public function getTables()
{
    $tables = DB::select('SHOW TABLES');
    return response()->json(['tables' => $tables]);
}
public function getTables1()
{
    $tables = DB::select('SHOW TABLES');
    return response()->json(['tables' => $tables]);
}


public function getColumns(Request $request)
{
    $tableName = $request->input('table');

    if (!$tableName) {
        return response()->json(['error' => 'Table name is required'], 400);
    }

    try {
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        return response()->json(['columns' => $columns]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error fetching columns: ' . $e->getMessage()], 500);
    }
}


public function generatepopup(Request $request)
{
    $moduleId = $request->query('module_id');
    $tableName = $request->query('table_name');
    $columns = Schema::getColumnListing($tableName);
    return view('backend.module.mvc', compact('moduleId', 'tableName', 'columns',));
}
//


//
public function generateMVC(Request $request)
{
    $moduleId = $request->input('moduleId');
    $tableName = $request->input('tableName');

    if (empty($tableName)) {
        logger()->error('Table Name is null or empty.');
        return back()->withErrors(['tableName' => 'Table name is required.']);
    }

    $columns = $request->input('columns', []);
    $inputTypes = $request->input('input_types', []);
    $columnss = Schema::getColumnListing($tableName);
 
    $dropdownOptions = json_decode($request->input('dropdown_options'), true);
    // dd($dropdownOptions);
    if (empty($columns)) {
        return redirect()->route('module.index')->withErrors(['columns' => 'Please select at least one column.']);
    }

    $modelName = Str::studly(Str::singular($tableName));
    $controllerName = $modelName . 'Controller';
    $controllerPath = app_path('Http/Controllers/' . $controllerName . '.php');
    $modelPath = app_path('Models/' . $modelName . '.php');
    $viewsPath = resource_path('views/backend/' . $tableName);

    // Model Creation
    if (!file_exists($modelPath)) {
        $this->createModel($modelName, $columns);
    } else {
        logger()->warning("Model $modelName already exists.");
    }

    // Controller Creation
    if (!file_exists($controllerPath)) {
        $this->createController($controllerName, $modelName, $tableName, $dropdownOptions, $columns, $columnss);
    } else {
        logger()->warning("Controller $controllerName already exists.");
    }

    // View Creation
    if (!is_dir($viewsPath)) {
        File::ensureDirectoryExists($viewsPath); // Ensure directory exists
        $this->createViews($tableName, $columns, $inputTypes, $dropdownOptions);
    } else {
        logger()->warning("Views for $tableName already exist.");
    }

    // Route Addition
    $routePath = base_path('routes/web.php');
    $routeDefinition = "\nRoute::resource('$tableName', \\App\\Http\\Controllers\\$controllerName::class);";

    if (!str_contains(file_get_contents($routePath), $routeDefinition)) {
        File::append($routePath, $routeDefinition);
    } else {
        logger()->warning("Route for $tableName already exists.");
    }

    return redirect()->route('module.index')->with('success', 'MVC files generated successfully!');
}

protected function createModel($modelName, $columns)
{
    $modelTemplate = "<?php

 namespace App\Models;
 
 use Illuminate\Database\Eloquent\Factories\HasFactory;
 use Illuminate\Database\Eloquent\Model;
 
 class $modelName extends Model
 {
     use HasFactory;
 
     protected \$fillable = [
         " . implode(", ", array_map(fn($col) => "'$col'", $columns)) . "
     ];
 }";
    File::put(app_path("Models/$modelName.php"), $modelTemplate);
}

protected function createController($controllerName, $modelName, $tableName)
{
    $controllerTemplate = "<?php

 namespace App\Http\Controllers;
 
 use App\Models\\$modelName;
 use Illuminate\Http\Request;
 
 class $controllerName extends Controller
 {
     public function index()
     {
         \$data = $modelName::all();
         return view('backend.$tableName.index', compact('data'));
     }
 
     public function create()
     {
         return view('backend.$tableName.create');
     }
 
         public function store(Request \$request)
     {
         // Directly create the model with the incoming data
         $modelName::create(\$request->all());
 
         // Redirect to the index page with a success message
         return redirect()->route('$tableName.index')->with('success', '$modelName created successfully.');
     }
         
     public function edit(\$id)
     {
         \$item = $modelName::findOrFail(\$id);
         return view('backend.$tableName.edit', compact('item'));
     }
 
 
 
     public function update(Request \$request, \$id)
     {
         // Find the item by ID
         \$item = $modelName::findOrFail(\$id);
 
         // Update the item with the incoming data
         \$item->update(\$request->all());
 
         // Redirect to the index page with a success message
         return redirect()->route('$tableName.index')->with('success', '$modelName updated successfully.');
     }
  
       public function destroy(\$id)
     {
         $modelName::where('id',\$id)->firstorfail()->delete();
         return redirect()->route('$tableName.index')
                                 ->with('deleted successfully');
     }
 
 }";
     
    File::put(app_path("Http/Controllers/$controllerName.php"), $controllerTemplate);
}

protected function createViews($tableName, $columns, $inputTypes, $dropdownOptions)
{
    $indexTemplate = "@extends('backend.layouts.app')

 @section('content')
 <title>{{ ucfirst('$tableName') }} List</title>
 
 <div class=\"row\">
     <div class=\"col-lg-12 margin-tb\">
         <div class=\"pull-left\">
             <h2>{{ ucfirst('$tableName') }} List</h2>
         </div>
         <div class=\"pull-right\">
             <a class=\"btn btn-success mb-2\" href=\"{{ route('$tableName.create') }}\">
                 Add New
             </a>
         </div>
     </div>
 </div>
 
 <table class=\"table table-bordered\">
     <thead>
         <tr>
             " . implode('', array_map(fn($col) => "<th>{{ ucfirst('$col') }}</th>", $columns)) . "
             <th>Actions</th>
         </tr>
     </thead>
     <tbody>
         @foreach(\$data as \$row)
         <tr>
             " . implode('', array_map(fn($col) => "<td>{{ \$row->$col }}</td>", $columns)) . "
             <td>
                 <a href=\"{{ route('$tableName.edit', \$row->id) }}\" class=\"btn btn-primary btn-sm\">Edit</a>
                 <form action=\"{{ route('$tableName.destroy', \$row->id) }}\" method=\"POST\" style=\"display:inline;\">
                     @csrf
                     @method('DELETE')
                     <button type=\"submit\" class=\"btn btn-danger btn-sm\">Delete</button>
                 </form>
             </td>
         </tr>
         @endforeach
     </tbody>
 </table>
 
 @endsection";
 
     $createTemplate = "@extends('backend.layouts.app')
 
 @section('content')
 <title>Add {{ ucfirst('$tableName') }}</title>
 
 <h2>Add {{ ucfirst('$tableName') }}</h2>
 
 <form action=\"{{ route('$tableName.store') }}\" method=\"POST\">
     @csrf
     <div class=\"row\">
         " . implode('', array_map(function ($col, $type) {
             if ($type === 'textarea') {
                 return "<div class=\"col-xs-12 col-sm-12 col-md-12\">
                             <div class=\"form-group\">
                                 <strong>{{ ucfirst('$col') }}:</strong>
                                 <textarea name=\"$col\" id=\"$col\" class=\"form-control\" required></textarea>
                             </div>
                         </div>";
             } else {
                 return "<div class=\"col-xs-12 col-sm-12 col-md-12\">
                             <div class=\"form-group\">
                                 <strong>{{ ucfirst('$col') }}:</strong>
                                 <input type=\"$type\" name=\"$col\" id=\"$col\" class=\"form-control\" required>
                             </div>
                         </div>";
             }
         }, array_keys($inputTypes), $inputTypes)) . "
 
         <div class=\"col-xs-12 col-sm-12 col-md-12 text-center\">
             <button type=\"submit\" class=\"btn btn-success\">Save</button>
         </div>
     </div>
 </form>
 
 @endsection";
 
     $editTemplate = "@extends('backend.layouts.app')
 
 @section('content')
 <h2>Edit {{ ucfirst('$tableName') }}</h2>
 
 <form action=\"{{ route('$tableName.update', \$item->id) }}\" method=\"POST\">
     @csrf
     @method('PUT')
     <div class=\"row\">
         " . implode('', array_map(function ($col, $type) use ($dropdownOptions) {
             if ($type === 'textarea') {
                 return "<div class=\"col-md-12\">
                             <div class=\"form-group\">
                                 <strong>{{ ucfirst('$col') }}:</strong>
                                 <textarea name=\"$col\" class=\"form-control\">{{ \$item->$col }}</textarea>
                             </div>
                         </div>";
             } elseif ($type === 'select') {
                 // Handle dropdown options correctly
                 $options = isset($dropdownOptions[$col]) ? json_encode($dropdownOptions[$col]) : '[]';
                 return "<div class=\"col-md-12\">
                             <div class=\"form-group\">
                                 <strong>{{ ucfirst('$col') }}:</strong>
                                 <select name=\"$col\" class=\"form-control\">
                                     @foreach(json_decode('$options', true) as \$key => \$value)
                                         <option value=\"{{ \$key }}\" {{ \$item->$col == \$key ? 'selected' : '' }}>{{ \$value }}</option>
                                     @endforeach
                                 </select>
                             </div>
                         </div>";
             } else {
                 return "<div class=\"col-md-12\">
                             <div class=\"form-group\">
                                 <strong>{{ ucfirst('$col') }}:</strong>
                                 <input type=\"$type\" name=\"$col\" class=\"form-control\" value=\"{{ \$item->$col }}\">
                             </div>
                         </div>";
             }
         }, array_keys($inputTypes), $inputTypes)) . "
 
         <div class=\"col-md-12 text-center\">
             <button type=\"submit\" class=\"btn btn-success\">Update</button>
         </div>
     </div>
 </form>
 @endsection";
 
     $path = resource_path("views/backend/$tableName");
     File::ensureDirectoryExists($path);
 
     File::put("$path/index.blade.php", $indexTemplate);
     File::put("$path/create.blade.php", $createTemplate);
     File::put("$path/edit.blade.php", $editTemplate);
}




}