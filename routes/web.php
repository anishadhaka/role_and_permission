<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Middleware\RolePermissionMiddleware;
use App\Http\Middleware\ValidUser;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsCategoryController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\BlogSite;
use App\Http\Controllers\ActionUserController;




Route::get('/', function () {
    return view('welcome');
});
Route::post('/action-user-store',[ActionUserController::class , 'store']);

Auth::routes();
Route::middleware(['auth'])->group(function () {
   


Route::get('/blogsite', [BlogSite::class, 'index'])->name('blogsite');
Route::get('/contactus', [BlogSite::class, 'contactUs'])->name('contactus');
Route::get('/about', [BlogSite::class, 'about'])->name('about');
Route::get('/Blogs/{article}', [BlogSite::class, 'blogsbyslug']);
Route::get('/News/{slug}', [BlogSite::class, 'newsbyslug']);
Route::get('/category/{title}', [BlogSite::class, 'blogsitecateg'])->name('blogsite.category');
Route::get('/categories/{category}', [BlogController::class, 'showCategory'])->name('blogs.category');
Route::get('/blogs/{title}/{slug}', [BlogController::class, 'showBlog'])->name('blogs.show');
Route::get('/blogcategoriasite', [BlogSite::class, 'blogCategorySite'])->name('blogcategories');
Route::get('/newscategoriasite', [BlogSite::class, 'newsCategorySite'])->name('newscategories');

    //
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('/module', ModuleController::class);
   
    Route::get('/module/{id}/access', [ModuleController::class, 'showAccess'])->name('access');

    Route::post('/module/save-permissions', [ModuleController::class, 'savePermissions'])->name('modulesave')->middleware(['role:module|Admin']); 
    Route::get('/module/permissions/{id}', [ModuleController::class, 'getPermissions'])->name('module.permissions')->middleware(['role:module|Admin']); 
    Route::delete('/module/permissions/{id}', [ModuleController::class, 'destroyPermission'])->name('permission.destroy')->middleware(['role:module|Admin']); 
   
    Route::resource('roles', RoleController::class)->middleware(['role:roles|Admin']);
    Route::resource('users', UserController::class)->middleware('role:Admin');
    Route::resource('products', ProductController::class)->middleware('role:product|Admin');
    Route::resource('blog', BlogController::class)->middleware(['role:blog|Admin','permission:blog-list| blog-create| blog-edit| blog-delete']); 
    Route::resource('blogCategory', BlogCategoryController::class)->middleware(['role:blogcategory|Admin','permission:blogcategory-list| blogcategory-create| blogcategory-edit| blogcategory-delete']);
    Route::resource('news', NewsController::class)->middleware(['role:news|Admin','permission:news-list| news-create| news-edit| news-delete']);
    Route::resource('newsCategory', NewsCategoryController::class)->middleware(['role:newscategory|Admin','permission:newscategory-list| newscategory-create| newscategory-edit| newscategory-delete']);
    Route::resource('pages', PagesController::class)->middleware(['role:pages|Admin','permission:pages-list| pages-create| pages-edit| pages-delete']);
    Route::resource('module', ModuleController::class)->middleware(['role:module|Admin']);  
    // Route::resource('action-user', ActionUserController::class);
   

});
