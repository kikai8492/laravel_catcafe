<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Models\Blog;
use App\Http\Requests\Admin\UpdateBlogRequest;
use Illuminate\Support\Facades\Storage; 
use App\Models\Category;
use App\Models\Cat;
// use Illuminate\Support\Facades\Auth; 

class AdminBlogController extends Controller
{
    //ブログ一覧画面
    public function index()
    {
			// $user = \Illuminate\Support\Facades\Auth;::user();
			$blogs = Blog::latest('updated_at')->simplePaginate(10);
      return view('admin.blogs.index', ['blogs' => $blogs ]);
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

		public function edit(Blog $blog)
		{
			$categories = Category::all();
			$cats = Cat::all();
			return view('admin.blogs.edit', [
																				'blog' => $blog, 
																				'categories' => $categories, 
																				'cats' => $cats
																			]);
		}

		public function update(UpdateBlogRequest $request, string $id)
		{
			$blog = Blog::findOrFail($id);
			$updateData = $request->validated();

			if($request->has('image')) {
				Storage::disk('public')->delete($blog->image);
				$updateData['image'] = $request->file('image')->store('blogs','public');
		  }
			$blog->category()->associate($updateData['category_id']);
			$blog->update($updateData);
			$blog->cats()->sync($updateData['cats'] ?? []);

			return to_route('admin.blogs.index')->with('success', 'ブログを更新しました');
	  }

		//ブログ削除
		public function destroy(string $id)
		{
			$blog = Blog::findOrFail($id);
			$blog->delete();
			Storage::disk('public')->delete($blog->image);
			return to_route('admin.blogs.index')->with('success', 'ブログを削除しました');

		}
}
