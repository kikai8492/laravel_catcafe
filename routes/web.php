<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\admin\AdminBlogController;

Route::view('/','index');

Route::get('/contact',[ContactController::class, 'index']) -> name('contact');
Route::post('/contact', [ContactController::class, 'sendMail']);
Route::get('/contact/complete',[ContactController::class, 'complete']) -> name('contact.complete');

//ブログ
Route::get('/admin/blogs',[AdminBlogController::class, 'index'])->name('admin.blogs.index');
Route::get('/admin/blogs/create',[AdminBlogController::class, 'create'])->name('admin.blogs.create');
Route::post('/admin/blogs', [AdminBlogController::class, 'store']) ->name('admin.blogs.store');
Route::get('/admin/blogs/{blogs}',[AdminBlogController::class, 'edit'])->name('admin.blogs.edit');
Route::put('/admin/blogs/{blogs}',[AdminBlogController::class, 'update'])->name('admin.blogs.update');
