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


// use App\Models\Permission;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;


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


public function generateMVC($id)
{
    $module = Module::findOrFail($id);
    $moduleName = ucfirst($module->Title);

    try {
        // Check if the model already exists
        $modelPath = app_path("Models/{$moduleName}.php");
        if (File::exists($modelPath)) {
            return response()->json(['message' => "Model '{$moduleName}' already exists!"], 400);
        }

        // Check if the controller already exists
        $controllerPath = app_path("Http/Controllers/{$moduleName}Controller.php");
        if (File::exists($controllerPath)) {
            return response()->json(['message' => "Controller '{$moduleName}Controller' already exists!"], 400);
        }

        // Check if the views folder already exists
        $viewPath = resource_path("views/{$module->Title}");
        if (File::exists($viewPath)) {
            return response()->json(['message' => "View directory for '{$moduleName}' already exists!"], 400);
        }

        // Check if the migration file already exists
        $migrationPath = database_path("migrations");
        $migrationFile = now()->format('Y_m_d_His') . "_create_{$module->Title}_table.php";
        if (File::exists("{$migrationPath}/{$migrationFile}")) {
            return response()->json(['message' => "Migration file '{$migrationFile}' already exists!"], 400);
        }

        // Generate the model
        $modelTemplate = "<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class {$moduleName} extends Model
{
    use HasFactory;

    protected \$fillable = ['field1', 'field2']; // Define your fields here
}
";
        File::put($modelPath, $modelTemplate);

        // Generate the controller
        $controllerTemplate = "<?php

namespace App\Http\Controllers;

use App\Models\\{$moduleName};
use Illuminate\Http\Request;

class {$moduleName}Controller extends Controller
{
    public function index()
    {
        \$data = {$moduleName}::all();
        return view('{$module->Title}.index', compact('data'));
    }

    public function create()
    {
        return view('{$module->Title}.create');
    }

    public function store(Request \$request)
    {
        {$moduleName}::create(\$request->all());
        return redirect()->route('{$module->Title}.index')->with('success', 'Created successfully.');
    }
}
";
        File::put($controllerPath, $controllerTemplate);

        // Generate the view directory
        File::makeDirectory($viewPath, 0755, true);

        // Add a basic index view file
        $indexViewPath = "{$viewPath}/index.blade.php";
        $indexViewTemplate = "<h1>{$moduleName} Index</h1>";
        File::put($indexViewPath, $indexViewTemplate);

        // Generate the migration file
        $migrationTemplate = "<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('{$module->Title}', function (Blueprint \$table) {
            \$table->id();
            \$table->string('field1'); // Example fields
            \$table->string('field2');
            \$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('{$module->Title}');
    }
};
";
        File::put("{$migrationPath}/{$migrationFile}", $migrationTemplate);

        // Add routes
        $routePath = base_path('routes/web.php');
        $routeDefinition = "
Route::resource('{$module->Title}', \\App\\Http\\Controllers\\{$moduleName}Controller::class);
";
        File::append($routePath, $routeDefinition);

        return response()->json(['message' => 'MVC files, route, and migration generated successfully!']);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error generating MVC files: ' . $e->getMessage()], 500);
    }
}


}