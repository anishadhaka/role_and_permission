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
 
public function index(Request $request): View
{
    $data = Blog::where('user_id',auth()->user()->id)->latest()->paginate(5);
 //   dd($data['items']);
    return view('blog.index',compact('data'))
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

    
    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $data['image'] = 'images/' . $imageName;  
    } else {
        $data['image'] = 'images/default-image.jpg'; 
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
    $user = Blog::where('user_id',auth()->user()->id)->where('id',$id)->firstOrFail();
    return view('blog.show',compact('user'));
}
  
public function edit($id): View
{
    $blog = Blog::where('user_id',auth()->user()->id)->where('id',$id)->firstOrFail();
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
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $data['image'] = 'images/' . $imageName;
    } else {
        $data['image'] = 'images/default-image.jpg';
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
    Blog::where('user_id',auth()->user()->id)->where('id',$id)->firstOrFail()->delete();
    return redirect()->route('blog.index')
                    ->with('success','User deleted successfully');
}
}
