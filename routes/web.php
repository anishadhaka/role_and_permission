<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware('auth')->group(function () {
   
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('module', ModuleController::class);
    Route::post('/module/save-permissions', [ModuleController::class, 'savePermissions'])->name('modulesave');
    Route::get('/module/permissions/{id}', [ModuleController::class, 'getPermissions'])->name('module.permissions');
    Route::delete('/module/permissions/{id}', [ModuleController::class, 'destroyPermission'])->name('permission.destroy');
   
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('blog', BlogController::class); 
    Route::resource('blogCategory', BlogCategoryController::class);
    Route::resource('news', NewsController::class);
    Route::resource('newsCategory', NewsCategoryController::class);
    Route::resource('pages', PagesController::class);
    Route::resource('module', ModuleController::class);  


});
