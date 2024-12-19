<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News;
use Spatie\Permission\Models\Role;
use App\Models\NewsCategory;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
    
class NewsController extends Controller
{
 
public function index(Request $request): View
{
    $data = News::where('user_id',auth()->user()->id)->latest()->paginate(5);
 //   dd($data['items']);
    return view('news.index',compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
}
    
   
public function create(): View
{
    // $roles = Role::pluck('name','name')->all();
    $categories = NewsCategory::pluck('title', 'id')->all();
    return view('news.create',compact('categories'));
}
    
  
public function store(Request $request): RedirectResponse
{
  
    $this->validate($request, [
        'name' => 'required',
        'description' => 'required',
        // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
    ]);

  
    $data = [
        'category_id'=>$request->category_id,
        'user_id' => auth()->user()->id,
        'name' => $request->name,
        'description' => $request->description,
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
    $existingSlugCount = News::where('slug', $slug)->count();
    if ($existingSlugCount > 0) {
        $slug = $slug . '-' . time();
    }
    $data['slug'] = $slug;

   
    News::create($data);

    return redirect()->route('news.index')
        ->with('success', 'News post created successfully');
}
    
  
public function show($id): View
{
    $news = News::where('user_id',auth()->user()->id)->find($id);
    return view('news.show',compact('news'));
}
  
public function edit($id): View
{
    $News = News::where('user_id',auth()->user()->id)->where('id',$id)->firstOrFail();
    $categories = NewsCategory::pluck('title', 'id');

    return view('news.edit',compact('News','categories'));
}
    
  
public function update(Request $request, $id): RedirectResponse
{
    
    $this->validate($request, [
        'name' => 'required|string|max:255', 
        'description' => 'required|string',       
        'create_date' => 'nullable|date',     
        'update_date' => 'nullable|date',    
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
    $existingSlugCount = News::where('slug', $slug)->count();
    if ($existingSlugCount > 0) {
        $slug = $slug . '-' . time();
    }
    $data['slug'] = $slug;

    $News = News::find($id);
    $News->update($data); 


    return redirect()->route('news.index') 
                     ->with('success', 'News updated successfully');
}
    
    
public function destroy($id): RedirectResponse
{
    News::where('user_id',auth()->user()->id)->where('id',$id)->firstOrFail()->delete();
    return redirect()->route('news.index')
                    ->with('success','User deleted successfully');
}
}


