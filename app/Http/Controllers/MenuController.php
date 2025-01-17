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
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;



class MenuController extends Controller
{
   
public function index(Request $request):view
{
    {
        $data = Menu::latest()->paginate(5);
  
        return view('menu.index',compact('data'));
    }
}

public function create()
{
    return view('menu.create');
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
    return view('menu.edit',compact('menu'));
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

public function showmenu($id){
    $menu = Menu::whereid($id)->first();
    $finalmenu_output = json_decode($menu, true);
    // dd($finalmenu_output);
    if ($finalmenu_output ) {
        return view('menu.menu', compact('finalmenu_output'));
    } else {
        return redirect()->route('menulist')->with('error', 'Menu not found');
   }
    
}

public function updatejsondata(Request $request)
{
    $menu = Menu::find($request->id);

    if ($menu) {
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

        $menu->json_output = json_encode($jsonDataArray);

        if ($menu->save()) {
            // Generate model, controller, and views for each item
            foreach ($jsonDataArray as $item) {
                $modelName = Str::studly($item['text']);
                $controllerName = "{$modelName}Controller";
                $viewFolder = Str::kebab($modelName);

                // Generate model
                Artisan::call("make:model {$modelName} -m");

                // Generate controller
                Artisan::call("make:controller {$controllerName}");

                // Add methods to the controller
                $controllerPath = app_path("Http/Controllers/{$controllerName}.php");
                $controllerContent = file_get_contents($controllerPath);
                $methods = <<<EOD

    // Index method
    public function index()
    {
        return view('{$viewFolder}.index');
    }

    // Create method
    public function create()
    {
        return view('{$viewFolder}.create');
    }

    // Edit method
    public function edit()
    {
        return view('{$viewFolder}.edit');
    }

EOD;

                $controllerContent = preg_replace(
                    '/\{/',
                    "{\n" . $methods,
                    $controllerContent,
                    1
                );
                file_put_contents($controllerPath, $controllerContent);

                // Create views
                $viewDirectory = resource_path("views/{$viewFolder}");
                if (!File::exists($viewDirectory)) {
                    File::makeDirectory($viewDirectory, 0755, true);
                }
                $viewContent = "<h1>{$modelName} View</h1>";
                file_put_contents("{$viewDirectory}/index.blade.php", $viewContent);
                file_put_contents("{$viewDirectory}/create.blade.php", $viewContent);
                file_put_contents("{$viewDirectory}/edit.blade.php", $viewContent);

                // Register routes dynamically
                $this->registerDynamicRoutes($modelName);
            }

            return redirect()->route('menu.index')->with('success', 'Menu and related files updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update the menu.');
        }
    } else {
        return redirect()->route('menu.index')->with('error', 'Menu not found.');
    }
}

/**
 * Dynamically register routes for the generated controller.
 */
private function registerDynamicRoutes($modelName)
{
    $controllerName = "{$modelName}Controller";
    $routeFile = base_path('routes/web.php');
    $routeContent = "\n\n// Routes for {$modelName}\n";
    $routeContent .= "Route::resource('" . Str::kebab($modelName) . "', '{$controllerName}');\n";

    file_put_contents($routeFile, $routeContent, FILE_APPEND);
}

}
