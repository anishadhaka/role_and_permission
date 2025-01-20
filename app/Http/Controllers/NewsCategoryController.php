<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
    
class NewsCategoryController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:newscategory-list|newscategory-create|newscategory-edit|newscategory-delete', ['only' => ['index','store']]);
         $this->middleware('permission:newscategory-create', ['only' => ['create','store']]);
         $this->middleware('permission:newscategory-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:newscategory-delete', ['only' => ['destroy']]);
    }
public function index(Request $request): View
{
    $data = NewsCategory::latest()->paginate(5);
 //   dd($data['items']);
    return view('backend.newsCategory.index',compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
}
    
   
public function create(): View
{
    $roles = Role::pluck('name','name')->all();
    return view('backend.newsCategory.create',compact('roles'));
}
    
  
public function store(Request $request): RedirectResponse
{
  
    $this->validate($request, [
        'title' => 'required',
        'meta_description' => 'required',
    ]);

  
    $data = [
        'title' => $request->title,
        'meta_description' => $request->meta_description,
        'meta_keyword' => $request->meta_keyword,
        'seo_robat' => $request->seo_robat,
        'create_date' => $request->created_at ?? now(),
        'update_date' => $request->updated_at ?? now(),
    ];

    NewsCategory::create($data);

    return redirect()->route('newsCategory.index')
        ->with('success', 'NewsCategory post created successfully');
}
    
  
public function show($id): View
{
    $user = NewsCategory::find($id);
    return view('backend.newsCategory.show',compact('user'));
}
  
public function edit($id): View
{
    $NewsCategory = NewsCategory::find($id);
    // $userRole = $user->roles->pluck('name','name')->all();

    return view('backend.newsCategory.edit',compact('NewsCategory'));
}
    
  
public function update(Request $request, $id): RedirectResponse
{
    
    $this->validate($request, [
        'title' => 'required',
        'meta_description' => 'required',
        'meta_keyword' => 'required|string', 
        'seo_robat' => 'required|string',  
        'create_date' => 'nullable|date',     
        'update_date' => 'nullable|date',    
    ]);

  
    $data = $request->all();


    $NewsCategory = NewsCategory::find($id);
    $NewsCategory->update($data); 


    return redirect()->route('newsCategory.index') 
                     ->with('success', 'newsCategory updated successfully');
}
    
    
public function destroy($id): RedirectResponse
{
    NewsCategory::find($id)->delete();
    return redirect()->route('newsCategory.index')
                    ->with('success','User deleted successfully');
}
}
    