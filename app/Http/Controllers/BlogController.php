<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\BlogCategory;
use App\Models\BlogCategory;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
    
class BlogController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:blog-list|blog-create|blog-edit|blog-delete', ['only' => ['index','store']]);
         $this->middleware('permission:blog-create', ['only' => ['create','store']]);
         $this->middleware('permission:blog-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:blog-delete', ['only' => ['destroy']]);
    }
 
    public function index(Request $request): View
    {
        $blogs = Blog::with('blogcategories');
        // print_r(auth()->user()->hasRole('Admin'));die;
        if(!auth()->user()->hasRole('Admin')){
            $blogs->where('user_id', auth()->user()->id);
        }
        if ($request->search) {
            $blogs->where('name', 'like', '%' . $request->search . '%');
        }
    
        $blogs = $blogs->latest()->paginate(5);
    
        return view('blog.index', compact('blogs'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    
   
public function create(): View
{
   
    $categories = BlogCategory::pluck('title', 'id')->all();
    return view('blog.create',compact('categories'));
}
    
  
public function store(Request $request): RedirectResponse
{
   
    $this->validate($request, [
        'name' => 'required',
        'content' => 'required',
    ]);

  
    $data = [
        'name' => $request->name,
        'content' => $request->content,
        'category_id'=>$request->category_id,
        'user_id' => auth()->user()->id,
        'create_date' => $request->created_at ?? now(),
        'update_date' => $request->updated_at ?? now(),
    ];

    
    $data = $request->all();
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = 'images/' . $imageName;
        $image->move(public_path('images'), $imageName);
        $blog->image = $imagePath;
    }
 
    $slug = Str::slug($request->name);
    $existingSlugCount = Blog::where('slug', $slug)->count();
    if ($existingSlugCount > 0) {
        $slug = $slug . '-' . time();
    }
    $data['slug'] = $slug;

   
    Blog::create($data);
  

    return redirect()->route('blog.index')
        ->with('success', 'Blog post created successfully');
}
    
  
public function show($id): View
{
    $user = Blog::where('id',$id)->firstOrFail();
    if(!auth()->user()->hasRole('Admin')){
        $user->where('user_id', auth()->user()->id);
    }
    return view('blog.show',compact('user'));
}
  
public function edit($id): View
{
    $blog = Blog::where('id',$id)->firstOrFail();
    if(!auth()->user()->hasRole('Admin')){
        $user->where('user_id', auth()->user()->id);
    }
    $categories = BlogCategory::pluck('title', 'id');
    // dd($categories);

    return view('blog.edit', compact('blog', 'categories'));
}
    
  
public function update(Request $request, $id): RedirectResponse
{
    $this->validate($request, [
        'name' => 'required|string|max:255',
        'content' => 'required|string',     
    ]);

    $data = $request->all();
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = 'images/' . $imageName;
        $image->move(public_path('images'), $imageName);
        $blog->image = $imagePath;
    }


    $slug = Str::slug($request->name);
    $existingSlugCount = Blog::where('slug', $slug)->count();
    if ($existingSlugCount > 0) {
        $slug = $slug . '-' . time();
    }
    $data['slug'] = $slug;

    $blog = Blog::findOrFail($id);
    $blog->update($data);

    if ($request->has('roles')) {
        $blog->categories()->sync($request->input('roles'));
    }

    return redirect()->route('blog.index')->with('success', 'Blog updated successfully');
}
    
    
public function destroy($id): RedirectResponse
{
    Blog::where('id',$id)->firstOrFail()->delete();
    if(!auth()->user()->hasRole('Admin')){
        $user->where('user_id', auth()->user()->id);
    }
    return redirect()->route('blog.index')
                    ->with('success','User deleted successfully');
}
}
