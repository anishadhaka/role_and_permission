<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Domain;
use App\Models\Language;
use App\Models\Status;


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
 
    function __construct()
    {
         $this->middleware('permission:news-list|news-create|news-edit|news-delete', ['only' => ['index','store']]);
         $this->middleware('permission:news-create', ['only' => ['create','store']]);
         $this->middleware('permission:news-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:news-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request): View
    {
        $language = $request->get('language'); 
    
        $query = News::with(['categories', 'languages', 'domains']);
    
        if (!auth()->user()->hasRole('Admin')) {
            $query->where('user_id', auth()->user()->id);
        }
    
        if ($language) {
            $query->whereHas('languages', function ($query) use ($language) {
                $query->where('language_name', $language);
            });
        }
    
        $newss = $query->latest()->paginate(5);
    
        $languages = Language::pluck('language_name', 'id');
        $status = Status::pluck('status_name', 'id'); 
    
        return view('news.index', compact('newss', 'languages','status'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    
    
   
public function create(): View
{
    // $roles = Role::pluck('name','name')->all();
    $categories = NewsCategory::pluck('title', 'id')->all();
    $domains= Domain::pluck('domain_name','id');
    $languages= Language::pluck('language_name','id');
    return view('news.create',compact('categories','domains','languages'));
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
        'domain_id' => $request->domain_id,
        'language_id' => $request->language_id,
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
    $news = News::find($id);
    if (!auth()->user()->hasRole('Admin')) {
        $news->where('user_id', auth()->user()->id);
    }
    return view('news.show',compact('news'));
}
  
public function edit($id): View
{
    $News = News::where('id',$id)->firstOrFail();
    if (!auth()->user()->hasRole('Admin')) {
        $News->where('user_id', auth()->user()->id);
    }
    $categories = NewsCategory::pluck('title', 'id');
    $domains =Domain::pluck('domain_name','id');
    $languages=Language::pluck('language_name','id');
// dd($domains);
    return view('news.edit',compact('News','categories','domains','languages'));
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
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = 'images/' . $imageName;
        $image->move(public_path('images'), $imageName);
        $blog->image = $imagePath;
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
    News::where('id',$id)->firstOrFail()->delete();
    if (!auth()->user()->hasRole('Admin')) {
        $query->where('user_id', auth()->user()->id);
    }
    return redirect()->route('news.index')
                    ->with('success','User deleted successfully');
}

public function updateStatus(Request $request)
{
    $request->validate([
        'news_id' => 'required|exists:news,id',
        'status_id' => 'required|exists:statuses,id', 
    ]);

    $news = News::findOrFail($request->news_id);
    $news->status_id = $request->status_id;
    $news->save();

    return response()->json(['success' => 'Status updated successfully']);
}
}


