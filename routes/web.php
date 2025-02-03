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
use App\Http\Controllers\MenuController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\FileManagerControllerController;




Route::get('/', function () {
    return view('welcome');
});
Route::post('/action-user-store',[ActionUserController::class , 'store']);

Route::get('menu/{id}', [MenuController::class, 'showMenu'])->name('menu');
Route::post('/updatejsondata', [MenuController::class, 'updateJsonData'])->name('updatejsondata');

Route::post('/approve_book/{id}', [BlogController::class, 'approveBook'])->name('approve_book');
Route::post('/rejected_book/{id}', [BlogController::class, 'rejected'])->name('rejected_book');

Route::post('/approve/{id}', [NewsController::class, 'approve'])->name('approve');
Route::post('/reject/{id}', [NewsController::class, 'reject'])->name('reject');

// Route::post('/module/mvc/{id}', [ModuleController::class, 'generateMVC'])->name('module.generateMVC');
Route::post('recycle', [ModuleController::class, 'recycle'])->name('recycle');
Route::PUT('module/recover/{id}', [ModuleController::class, 'recover'])->name('module.recover');
Route::get('/module/get-tables', [ModuleController::class, 'getTables'])->name('module.getTables');
Route::get('/mvc/generate', [ModuleController::class, 'generatepopup'])->name('mvc.generate');
Route::post('/mvc/generate', [ModuleController::class, 'generateMVC'])->name('mvc.generate.mvc');

// Route::post('/update_status/{id}', [BlogController::class, 'updateStatus'])->name('update_status');
Route::get('/module/get-tables1', [ModuleController::class, 'getTables1'])->name('module.getTables1');
Route::get('/module/get-columns', [ModuleController::class, 'getColumns'])->name('fetch.columns');


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
    Route::resource('menu', MenuController::class)->middleware(['role:menu|Admin']);  
    // Route::resource('domain', DomainController::class);  
    Route::resource('domain', DomainController::class)->middleware(['role:domain|Admin']); 
    Route::resource('language', LanguageController::class)->middleware(['role:language|Admin']); 
    Route::resource('department', DepartmentController::class); 
    Route::resource('designation', DesignationController::class); 
    // Add this route to your routes/web.php
Route::post('/news/status/update', [NewsController::class, 'updateStatus'])->name('news.status.update');
Route::post('/blog/status/update', [BlogController::class, 'updateStatus'])->name('blogs.status.update');


});

Route::resource('Country', \App\Http\Controllers\CountryController::class);
Route::resource('City', \App\Http\Controllers\CityController::class);
Route::resource('State', \App\Http\Controllers\StateController::class);

// Route::get('/menulist', [MenuController::class, 'create'])->name('menulist');
Route::get('filemanager', [FileManagerControllerController::class, 'index'])->name('filemanager.index');



 
 Route::resource('tests', \App\Http\Controllers\TestController::class);
 