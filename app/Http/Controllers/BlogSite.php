<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\News;
use App\Models\ActionUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use App\Models\Menu;
use App\Models\module;
use App\Models\pages;


class BlogSite extends Controller
{
//     public function index()
// {
//     //  dd("jbj");
//     $blog = Blog::all(); 
//     $news = News::all(); 
//     $action= ActionUser::all();
//     $blogs = Blog::all()->map(function ($blog) {
//         $blog->isLiked = Auth::check() ? ActionUser::where('user_id', Auth::id())->where('action', 'like')->where('action_id', $blog->id)->where('type', 'blog')->whereNull('deleted_at')->exists() : false;
//         $blog->isDisliked = Auth::check() ? ActionUser::where('user_id', Auth::id())->where('action', 'dislike')->where('action_id', $blog->id)->where('type', 'blog')->whereNull('deleted_at')->exists() : false;
//         $blog->isFavorited = Auth::check() ? ActionUser::where('user_id', Auth::id())->where('action', 'favorite')->where('action_id', $blog->id)->where('type', 'blog')->whereNull('deleted_at')->exists() : false;
//         return $blog;
//     });

//     $news = News::all()->map(function ($newsItem) {
//         $newsItem->isLiked = Auth::check() ? ActionUser::where('user_id', Auth::id())->where('action', 'like')->where('action_id', $newsItem->id)->where('type', 'news')->whereNull('deleted_at')->exists() : false;
//         $newsItem->isDisliked = Auth::check() ? ActionUser::where('user_id', Auth::id())->where('action', 'dislike')->where('action_id', $newsItem->id)->where('type', 'news')->whereNull('deleted_at')->exists() : false;
//         $newsItem->isFavorited = Auth::check() ? ActionUser::where('user_id', Auth::id())->where('action', 'favorite')->where('action_id', $newsItem->id)->where('type', 'news')->whereNull('deleted_at')->exists() : false;
//         return $newsItem;
//     });
//     return view('frontend.blogsite.blogsite', compact('blog', 'news','blogs','news'));
// }

public function index()
{
        //  dd("jbj");
    $blog = Blog::all(); 
    $news = News::all(); 
    $action= ActionUser::all();
    $pages= pages::all();
    // dd($pages);
    $blogs = Blog::all()->map(function ($blog) {
        $blog->isLiked = Auth::check() ? ActionUser::where('user_id', Auth::id())->where('action', 'like')->where('action_id', $blog->id)->where('type', 'blog')->whereNull('deleted_at')->exists() : false;
        $blog->isDisliked = Auth::check() ? ActionUser::where('user_id', Auth::id())->where('action', 'dislike')->where('action_id', $blog->id)->where('type', 'blog')->whereNull('deleted_at')->exists() : false;
        $blog->isFavorited = Auth::check() ? ActionUser::where('user_id', Auth::id())->where('action', 'favorite')->where('action_id', $blog->id)->where('type', 'blog')->whereNull('deleted_at')->exists() : false;
        return $blog;
    });

    $news = News::all()->map(function ($newsItem) {
        $newsItem->isLiked = Auth::check() ? ActionUser::where('user_id', Auth::id())->where('action', 'like')->where('action_id', $newsItem->id)->where('type', 'news')->whereNull('deleted_at')->exists() : false;
        $newsItem->isDisliked = Auth::check() ? ActionUser::where('user_id', Auth::id())->where('action', 'dislike')->where('action_id', $newsItem->id)->where('type', 'news')->whereNull('deleted_at')->exists() : false;
        $newsItem->isFavorited = Auth::check() ? ActionUser::where('user_id', Auth::id())->where('action', 'favorite')->where('action_id', $newsItem->id)->where('type', 'news')->whereNull('deleted_at')->exists() : false;
        return $newsItem;
    });
    return view('frontend.blogsite.front',compact('blog', 'news','blogs','news','pages'));

}


public function blogsitecateg($categoryTitle)
{
    $category = BlogCategory::with('blogs')->where('title', $categoryTitle)->first();
    // dd($category->blogs);
        if (!$category) {
            abort(404, 'Category not found');
        }
    
        $blogs = $category->blogs;
    
        return view('frontend.blogsite.blogsitecateg', [
            'blogs' => $blogs,
    ]);
}

// public function showBlog($title, $slug)
// {
//     $blog = Blog::where('title', $title)->where('slug', $slug)->firstOrFail();
//     return view('frontend.blogs.show', compact('blog'));
// }


public function about()
{
    return view('frontend.blogsite.about');
}

public function show($Title)
{
    $post = Blog::findOrFail($Title); 
    $sideblog = Blog::all(); 
    
    return view('frontend.blogsite.readmore', compact('post','sideblog'));
}
public function contactUs()
{
    return view('frontend.blogsite.contactus');
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
// readmore
public function blogsbyslug($slug)
{
    $blog= Blog::with('blogcategories')->whereLike('slug', $slug)->first();
    // dd($blog);
    $related_blogs = Blog::where('category_id', $blog->blogcategories->id)->get();
    return view('frontend.blogsite.readmore',['blog' => $blog,'related_blogs'=>$related_blogs]);

}
public function newsbyslug($slug)
{
    $news= News::with('categories')->whereLike('slug', $slug)->first();
    // dd($news);

    $related_news = News::where('category_id', $news->categories->id)->get();
    return view('frontend.blogsite.readmorenews',['news' => $news,'related_news'=>$related_news]);

}


// header 2
public function blogCategorySite()
{
    $blog = Blog::all(); 
    $blogs = Blog::all()->map(function ($blog) {
        $blog->isLiked = Auth::check() ? ActionUser::where('user_id', Auth::id())->where('action', 'like')->where('action_id', $blog->id)->where('type', 'blog')->whereNull('deleted_at')->exists() : false;
        $blog->isDisliked = Auth::check() ? ActionUser::where('user_id', Auth::id())->where('action', 'dislike')->where('action_id', $blog->id)->where('type', 'blog')->whereNull('deleted_at')->exists() : false;
        $blog->isFavorited = Auth::check() ? ActionUser::where('user_id', Auth::id())->where('action', 'favorite')->where('action_id', $blog->id)->where('type', 'blog')->whereNull('deleted_at')->exists() : false;
        return $blog;
    });

   
    return view('frontend.blogsite.blogcategories', compact('blog','blogs'));
}
public function newsCategorySite()
{
    $news = News::all(); 
    $newss = News::all()->map(function ($newsItem) {
        $newsItem->isLiked = Auth::check() ? ActionUser::where('user_id', Auth::id())->where('action', 'like')->where('action_id', $newsItem->id)->where('type', 'news')->whereNull('deleted_at')->exists() : false;
        $newsItem->isDisliked = Auth::check() ? ActionUser::where('user_id', Auth::id())->where('action', 'dislike')->where('action_id', $newsItem->id)->where('type', 'news')->whereNull('deleted_at')->exists() : false;
        $newsItem->isFavorited = Auth::check() ? ActionUser::where('user_id', Auth::id())->where('action', 'favorite')->where('action_id', $newsItem->id)->where('type', 'news')->whereNull('deleted_at')->exists() : false;
        return $newsItem;
    });
    return view('frontend.blogsite.NewsSitecategories', compact('news','newss'));
}

}