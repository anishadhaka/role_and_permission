<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\News;

class BlogSite extends Controller
{
    public function index()
{
    //  dd("jbj");
    $blog = Blog::all(); 
    $news = News::all(); 
    return view('blogsite.blogsite', compact('blog', 'news'));
}

public function blogsitecateg($categoryTitle)
{
    $category = BlogCategory::with('blogs')->where('title', $categoryTitle)->first();
    // dd($category->blogs);
        if (!$category) {
            abort(404, 'Category not found');
        }
    
        $blogs = $category->blogs;
    
        return view('blogsite.blogsitecateg', [
            'blogs' => $blogs,
    ]);
}

public function showBlog($title, $slug)
{
    $blog = Blog::where('title', $title)->where('slug', $slug)->firstOrFail();
    return view('blogs.show', compact('blog'));
}


public function about()
{
    return view('blogsite.about');
}

public function show($Title)
{
    $post = Blog::findOrFail($Title); 
    $sideblog = Blog::all(); 
    
    return view('/readmore', compact('post','sideblog'));
}
public function contactUs()
{
    return view('blogsite.contactus');
}
public function contactUsData(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string|max:1000',
    ]);
    Contact::create($validated);
    return redirect()->route('contactus')->with('success', 'Your message has been sent successfully!');
}

public function blogsbyslug($slug)
{
    $blog= Blog::with('blogcategories')->whereLike('slug', $slug)->first();
    // dd($blog);
    $related_blogs = Blog::where('category_id', $blog->blogcategories->id)->get();
    return view('blogsite.readmore',['blog' => $blog,'related_blogs'=>$related_blogs]);
}
public function newsbyslug($slug)
{
    $news= News::with('categories')->whereLike('slug', $slug)->first();
    $related_news = News::where('category_id', $news->categories->id)->get();
    return view('blogsite.readmorenews',['news' => $news,'related_news'=>$related_news]);
}


// header 2
public function blogCategorySite()
{
    $blog = Blog::all(); 
    return view('blogsite.blogcategories', compact('blog'));
}
public function newsCategorySite()
{
    $news = News::all(); 
    return view('blogsite.NewsSitecategories', compact('news'));
}

}


