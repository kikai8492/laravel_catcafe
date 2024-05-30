<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminBlogController extends Controller
{
    //ブログ一覧画面
    public function index()
    {
      return view('admin.blogs.index');
    }

    //ブログ投稿画面
    public function create() 
    {
			return view('admin.blogs.create');
    }
}
