<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
    
class BlogCategoryController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:blogcategory-list|blogcategory-create|blogcategory-edit|blogcategory-delete', ['only' => ['index','store']]);
         $this->middleware('permission:blogcategory-create', ['only' => ['create','store']]);
         $this->middleware('permission:blogcategory-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:blogcategory-delete', ['only' => ['destroy']]);
    }
public function index(Request $request): View
{
    $query = BlogCategory::query();
    // dd($query);
    if ($request->search) {
        $query->whereLike('title',  '%' . $request->search . '%');
     }
    $data = $query->latest()->paginate(5);

    return view('backend.blogCategory.index',compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
}
    
   
public function create(): View
{
    $roles = Role::pluck('name','name')->all();
    return view('backend.blogCategory.create',compact('roles'));
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

    BlogCategory::create($data);

    return redirect()->route('blogCategory.index')
        ->with('success', 'BlogCategory post created successfully');
}
    
  
public function show($id): View
{
    $user = BlogCategory::find($id);
    return view('backend.blogCategory.show',compact('user'));
}
  
public function edit($id): View
{
    $BlogCategory = BlogCategory::find($id);
    // $userRole = $user->roles->pluck('name','name')->all();

    return view('backend.blogCategory.edit',compact('BlogCategory'));
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


    $BlogCategory = BlogCategory::find($id);
    $BlogCategory->update($data); 


    return redirect()->route('blogCategory.index') 
                     ->with('success', 'BlogCategory updated successfully');
}
    
    
public function destroy($id): RedirectResponse
{
    BlogCategory::find($id)->delete();
    return redirect()->route('blogCategory.index')
                    ->with('success','User deleted successfully');
}
}
