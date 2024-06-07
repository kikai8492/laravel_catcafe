<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuthController;

Route::view('/','index');

Route::get('/contact',[ContactController::class, 'index']) -> name('contact');
Route::post('/contact', [ContactController::class, 'sendMail']);
Route::get('/contact/complete',[ContactController::class, 'complete']) -> name('contact.complete');

// //管理画面
      Route::prefix('/admin')
      ->name('admin.')
      ->group(function () {
          
          // 認証が必要なルート
          Route::middleware('auth')
              ->group(function(){
                //ブログ(show以外)
                Route::resource('/blogs', AdminBlogController::class)->except('show');
                
                //ユーザー管理
                Route::get('/users/create',[UserController::class, 'create'])->name('users.create');
                Route::post('/users', [UserController::class, 'store'])->name('users.store');
        
                //ログアウト
                Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
              });
            
          // ゲスト専用のルート
          Route::middleware('guest')
              ->group(function (){
                //認証
                Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
                Route::post('/login', [AuthController::class, 'login']);
              });
      });
