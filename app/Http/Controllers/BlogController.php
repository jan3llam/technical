<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Services\AuthService;
use App\Services\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    protected $blogService;
    protected $authService;
    public function __construct(BlogService $blogService, AuthService $authService)
    {
        $this->blogService = $blogService;
        $this->authService = $authService;
    }
    public function index(Request $request)
    {
        $blogs = $this->blogService->index($request);

        return view('blogs.index', compact('blogs'));
    }

    public function show($id)
    {
        $blog = $this->blogService->show($id);

        return view('blogs.blog_details', compact('blog'));
    }

    public function create()
    {
        return view('blogs.create');
    }

    public function store(Request $request)
    {
        $checkAuth = $this->authService->verifyAccessToken();
        if (!$checkAuth) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $data = $this->blogService->store($request);

        return response()->json(['message' => 'Blog created successfully.', 'data' => $data]);
    }

    public function edit()
    {
        $blog = $this->blogService->show(request()->id);

        return view('blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $checkAuth = $this->authService->verifyAccessToken();
        if (!$checkAuth) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $data = $this->blogService->update($request, $id);

        return response()->json(['message' => 'Blog updated successfully.', 'data' => $data]);
    }

    public function destroy($id)
    {
        $checkAuth = $this->authService->verifyAccessToken();
        if (!$checkAuth) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $data = $this->blogService->destroy($id);

        return response()->json(['message' => 'Blog deleted successfully.']);
    }
}
