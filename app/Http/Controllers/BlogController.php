<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Domain;
use App\Models\Language;
use App\Models\Status;
use App\Models\Designation;
use App\Models\ApprovedStatus;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;


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
    $language = $request->get('language'); 
    $blogs = Blog::with(['blogcategories', 'languages', 'domains', 'status', 'approvedstatus', 'designation', 'user'])
        ->paginate(5);
    // dd($blogs);
    if (!auth()->user()->hasRole('Admin')) {
        $blogs->where('user_id', auth()->user()->id);
    }
    if ($request->search) {
        $blogs->where('name', 'like', '%' . $request->search . '%');
    }
    if ($language) {
        $blogs->whereHas('languages', function ($query) use ($language) {
            $query->where('language_name', $language);
        });
    }
    $languages = Language::pluck('language_name', 'id'); 
    $status = Status::pluck('status_name', 'id'); 
    $designation = Designation::all();
    // dd($designation);
    
    return view('backend.blog.index', compact('blogs', 'languages', 'status', 'designation'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
}
    
    


   
public function create(): View
{
   
    $categories = BlogCategory::pluck('title', 'id')->all();
    $domains= Domain::pluck('domain_name','id');
    $languages= Language::pluck('language_name','id');
    $status= Status::pluck('status_name','id');
    $country=Country::all();
    
   return view('backend.blog.create',compact('categories','domains','languages','status','country'));
}
    
  
public function store(Request $request): RedirectResponse
{
   
    $request->validate([
        'name' => 'required|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|string|max:255', 
    ]);

    $data = [
        'name' => $request->name,
        'content' => $request->content,
        'category_id' => $request->category_id,
        'user_id' => auth()->user()->id,
        'domain_id' => $request->domain_id,
        'language_id' => $request->language_id,
        'status_id' => $request->status_id,
        'country_id' => $request->country_id,
        'create_date' => now(),
        'update_date' => now(),
    ];

        $data['image'] = $request->image;
   

   
    $slug = Str::slug($request->name);
    $existingSlugCount = Blog::where('slug', $slug)->count();
    if ($existingSlugCount > 0) {
        $slug = $slug . '-' . time();  
    }
    $data['slug'] = $slug;
    Blog::create($data);
    if ($request->has('stay_on_page') && $request->stay_on_page) {
        return redirect()->back()->with('success', 'Blog post created successfully. You can create another.');
    }
    return redirect()->route('blog.index')->with('success', 'Blog post created successfully');
}

    
  
public function show($id): View
{
    $user = Blog::where('id',$id)->firstOrFail();
    if(!auth()->user()->hasRole('Admin')){
        $user->where('user_id', auth()->user()->id);
    }
    return view('backend.blog.show',compact('user'));
}
  
public function edit($id): View
{
    $blog = Blog::where('id',$id)->firstOrFail();
    $domains= Domain::pluck('domain_name','id');
    $languages= Language::pluck('language_name','id');
    $status= Status::pluck('status_name','id');
    $country= Country::all();
    if(!auth()->user()->hasRole('Admin')){
        $user->where('user_id', auth()->user()->id);
    }
    $categories = BlogCategory::pluck('title', 'id');
    // dd($categories);
    return view('backend.blog.edit', compact('blog', 'categories','domains','languages','status','country'));
}
    
  
public function update(Request $request, $id): RedirectResponse
{
    $this->validate($request, [
        'name' => 'required|string|max:255',
        // 'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'content' => 'required|string',     
    ]);

    $blog = Blog::findOrFail($id);

    $data = $request->all();


    // dd($data);


    $slug = Str::slug($request->name);
    $existingSlugCount = Blog::where('slug', $slug)->count();
    if ($existingSlugCount > 0) {
        $slug = $slug . '-' . time();  
    }
    $data['slug'] = $slug;

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

public function updateStatus(Request $request)
{
    // echo 'test';die;
    $request->validate([
        'blog_id' => 'required|exists:blogs,id',
        'status_id' => 'required|exists:statuses,id', 
    ]);
    // echo 'test';die;
    // dd($request);
    $blog = Blog::findOrFail($request->blog_id);
    $blog->status_id = $request->status_id;
    $blog->save();
    return response()->json(['success' => 'Status updated successfully']);
}

public function approveBook($id)
{
    $blog = Blog::find($id);

    if (!$blog) {
        return redirect()->route('blog.index')->with('error', 'Blog not found.');
    }
    $designation_id = auth()->user()->designation_id;
    if (!$designation_id) {
        return redirect()->route('blog.index')->with('error', 'No designation found for the current user.');
    }
  
    ApprovedStatus::updateOrCreate(
        [
            'blog_id' => $id, 
        ],
        [
            'user_id' => auth()->id(), 
            'designation_id' => $designation_id,
            'approvel' => '1', 
        ]
    );

    return redirect()->route('blog.index')->with('success', 'Blog approved successfully!');
}


public function rejected($id)
{
    $blog = Blog::find($id);
    if (!$blog) {
        return redirect()->route('blog.index')->with('error', 'Blog not found.');
    }

    $designation_id = auth()->user()->designation_id;

    if (!$designation_id) {
        return redirect()->route('blog.index')->with('error', 'No designation found for the current user.');
    }
    ApprovedStatus::where('blog_id', $id)->delete();
    return redirect()->route('blog.index')->with('success', 'Blog rejected successfully!');
}



public function getStates($country_id)
{
    $states = State::where('country_id', $country_id)->pluck('name', 'id');
    // dd($states);
    return response()->json($states);
}

public function getCities($state_id)
{
    $cities = City::where('state_id', $state_id)->pluck('name', 'id');
    // dd($cities);

    return response()->json($cities);
}


}