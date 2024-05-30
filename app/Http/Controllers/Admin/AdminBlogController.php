<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Models\Blog;
use App\Http\Requests\Admin\UpdateBlogRequest;

class AdminBlogController extends Controller
{
    //ブログ一覧画面
    public function index()
    {
			$blogs = Blog::all();
      return view('admin.blogs.index', ['blogs' => $blogs]);
    }

    //ブログ投稿画面
    public function create() 
    {
			return view('admin.blogs.create');
    }

		//ブログ投稿処理
		public function store(StoreBlogRequest $request)
		{
			$validated = $request->validated();
			$validated['image'] = $request->file('image')->store('blogs', 'public');
			Blog::create($validated);

			return to_route('admin.blogs.index') -> with('success','ブログを投稿しました');
		}

		public function edit(string $id)
		{
			$blog = Blog::findOrFail($id);
			return view('admin.blogs.edit', ['blog' => $blog]);
		}

		public function update(UpdateBlogRequest $request, string $id)
		{
			$blog = Blog::findOrFail($id);
			$updateData = $request->validated();

			if($request->ha('image')) {
				storage::disk('public')->delete($blog->image);
				$updateData['image'] = $request->file('image')->store('blogs','public');
		  }
			$blog->update($updateData);

			return to_route('admin.blogs.index')->with('success', 'ブログを更新しました');
	  }

		public function destroy(string $id)
		{
			$blog = Blog::destroy($id);
			return view('admin.blogs.index', ['blog' => $blog]);
		}
}
