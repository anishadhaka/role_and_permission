<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pages;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
    
class PagesController extends Controller
{
 
public function index(Request $request): View
{
    $data = Pages::where('user_id',auth()->user()->id)->latest()->paginate(5);
 //   dd($data['items']);
    return view('pages.index',compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
}
    
   
public function create(): View
{
    // $roles = Role::pluck('name','name')->all();
    return view('pages.create');
}
    
  
public function store(Request $request): RedirectResponse
{
  
    $this->validate($request, [
        'title' => 'required',
        'description' => 'required',
    ]);

  
    $data = [
        'user_id' => auth()->user()->id,
        'title' => $request->title,
        'description' => $request->description,
        'create_date' => $request->created_at ?? now(),
        'update_date' => $request->updated_at ?? now(),
    ];

    

    $slug = Str::slug($request->title);
    $existingSlugCount = Pages::where('slug', $slug)->count();
    if ($existingSlugCount > 0) {
        $slug = $slug . '-' . time();
    }
    $data['slug'] = $slug;

   
    Pages::create($data);

    return redirect()->route('pages.index')
        ->with('success', 'Pages post created successfully');
}
    
  
public function show($id): View
{
    $pages = Pages::find($id);
    return view('pages.show',compact('pages'));
}
  
public function edit($id): View
{
    $pages = Pages::where('user_id',auth()->user()->id)->where('id',$id)->firstOrFail();
    // $userRole = $user->roles->pluck('name','name')->all();

    return view('pages.edit',compact('pages'));
}
    
  
public function update(Request $request, $id): RedirectResponse
{
    
    $this->validate($request, [
        'title' => 'required|string|max:255', 
        'description' => 'required|string|max:255', 
      
    ]);

  
    $data = $request->all();

    
    $slug = Str::slug($request->title);
    $existingSlugCount = Pages::where('slug', $slug)->count();
    if ($existingSlugCount > 0) {
        $slug = $slug . '-' . time();
    }
    $data['slug'] = $slug;

    $Pages = Pages::find($id);
    $Pages->update($data); 

   
    return redirect()->route('pages.index') 
                     ->with('success', 'Pages updated successfully');
}
    
    
public function destroy($id): RedirectResponse
{
    Pages::where('user_id',auth()->user()->id)->where('id',$id)->firstOrFail()->delete();
    return redirect()->route('pages.index')
                    ->with('success','User deleted successfully');
}
}

