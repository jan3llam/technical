<?php

namespace App\Services;

use App\Models\Blog;

class BlogService
{

    public function index($request)
    {
        $search = $request->input('search');
        $blogs = Blog::where('title', 'LIKE', "%$search%")->paginate(10);

        return $blogs;
    }

    public function show($id){
        $blog = Blog::findOrfail($id);

        return $blog;
    }

    public function store($request)
    {
        $data = $request->validate([
            'title' => 'required|string|min:2|max:255',
            'content' => 'required|string',
            'blog_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:' . Blog::STATUS_PUBLISHED . ',' . Blog::STATUS_DRAFT,
            'publish_date' => 'required|date',
        ]);

        $blog = blog::create($data);

        if ($request->hasFile('blog_image')) {

            $blog_image = $request->blog_image;
            $ext = '.' . $blog_image->getClientOriginalExtension();
            $filename = time() . $ext;
            $destination = public_path('uploads/blogs');
            $blog_image->move($destination, $filename);
            $blog->image = strtolower($filename);
        }

        $blog->save();

        return $data;
    }

    public function update($request, $id)
    {
        $blog = Blog::findOrfail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:' . Blog::STATUS_PUBLISHED . ',' . Blog::STATUS_DRAFT,
            'publish_date' => 'required|date',
        ]);

        $blog = $blog->update($data);

        return $blog;
    }

    public function destroy($id)
    {
        $blog = Blog::findOrfail($id);

        $blog->delete();

        return true;
    }

}
