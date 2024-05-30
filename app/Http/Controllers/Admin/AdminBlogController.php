<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Models\Blog;

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

		//ブログ投稿処理
		public function store(StoreBlogRequest $request)
		{
			$savedImagePath = $request->file('image')->store('blogs','public');
			$blog = new Blog($request->validated());
			$blog->image = $savedImagePath;
			$blog->save();

			return to_route('admin.blogs.index') -> with('success','ブログを投稿しました');
		}
}
