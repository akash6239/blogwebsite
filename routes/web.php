<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\PostController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\TagController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomeController::class,'index']);
Route::get('/about',[HomeController::class,'aboutus'])->name('aboutus');
Route::get('/teams',[HomeController::class,'teams'])->name('teams');
Route::get('/gallery',[HomeController::class,'gallery'])->name('gallery');    
Route::get('/blog',[HomeController::class,'blog'])->name('blog');    
Route::get('/contact',[HomeController::class,'contact'])->name('contact');    
Route::get('/contact', function () {
    return view('webapp.pages.contact');
})->name('contact');

Route::get('login',[AdminController::class,'login'])->name('login');
Route::post('login',[AdminController::class,'loginuser'])->name('loginuser');
Route::get('signup',[AdminController::class,'signup'])->name('signup');
Route::post('signup',[AdminController::class,'signupuser'])->name('signupuser');




Route::middleware('adminauth')->prefix('admin')->group(function () {
    
    Route::get('dashboard',[AdminController::class,'index'])->name('admin.dashboard');
                                    // user
    Route::get('user/add',[UserController::class,'adduser'])->name('adduser');
    Route::post('user/add',[UserController::class,'storeuser'])->name('storeuser');
    Route::get('user/view',[UserController::class,'viewuser'])->name('viewuser');
    Route::get('user/{id}/edit',[UserController::class,'edituser'])->name('edituser');
    Route::put('user/{id}/update',[UserController::class,'updateuser'])->name('updateuser');
    Route::get('user/{id}/delete',[UserController::class,'deleteuser'])->name('deleteuser');
                                    // category
    Route::get('category/add',[CategoryController::class,'addcategory'])->name('addcategory');
    Route::get('category/view',[CategoryController::class,'viewcategory'])->name('viewcategory');
    Route::post('category/store',[CategoryController::class,'storecategory'])->name('storecategory');
    Route::get('category/{id}/edit',[CategoryController::class,'editcategory'])->name('editcategory');
    Route::put('category/{id}/update',[CategoryController::class,'updatecategory'])->name('updatecategory');
    Route::get('category/{id}/delete',[CategoryController::class,'deletecategory'])->name('deletecategory');
                                // post
    Route::get('post/view',[PostController::class,'viewpost'])->name('viewpost');
    Route::get('post/add',[PostController::class,'addpost'])->name('addpost');
    Route::post('post/store',[PostController::class,'storepost'])->name('storepost');
    Route::get('post/{id}/edit',[PostController::class,'editpost'])->name('editpost');
    Route::put('post/{id}/update',[PostController::class,'updatepost'])->name('updatepost');
    Route::get('post/{id}/delete',[PostController::class,'deletepost'])->name('deletepost');
                        // tags
    Route::get('tag/view',[TagController::class,'viewtag'])->name('viewtag');
    Route::get('tag/add',[TagController::class,'addtag'])->name('addtag');
    Route::post('tag/store',[TagController::class,'storetag'])->name('storetag');
    Route::get('tag/{id}/edit',[TagController::class,'edittag'])->name('edittag');
    Route::put('tag/{id}/update',[TagController::class,'updatetag'])->name('updatetag');
    Route::get('tag/{id}/delete',[TagController::class,'deletetag'])->name('deletetag');

    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');

});

Route::get('blog/{slug}',[HomeController::class,'blogdetail'])->name('blogdetail');

