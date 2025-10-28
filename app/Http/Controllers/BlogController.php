<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'myBlogs']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('theme.blogs.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        $data = $request->validated();

        //image upload
        //1.get image
        $image = $request->file('image');
        //2.change it's current name
        $newImageName = time() . '-' . $image->getClientOriginalName();
        //3.move image to folder project
        $image->storeAs('blogs', $newImageName, 'public');
        //4.save new name to database record
        $data['image'] = $newImageName;
        $data['user_id'] = Auth::user()->id;

        //create new blog record
        Blog::create($data);

        return redirect()->back()->with('blogCreatedStatus', 'Blog created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view('theme.single-blog', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        if ($blog->user_id == Auth::user()->id) {
            $categories = Category::get();
            return view('theme.blogs.edit', compact('categories', 'blog'));
        }
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, BLog $blog)
    {
        if ($blog->user_id == Auth::user()->id) {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                //image upload
                //0.delete old image
                Storage::delete("public/blogs/$blog->image");
                //1.get image
                $image = $request->file('image');
                //2.change it's current name
                $newImageName = time() . '-' . $image->getClientOriginalName();
                //3.move image to folder project
                $image->storeAs('blogs', $newImageName, 'public');
                //4.save new name to database record
                $data['image'] = $newImageName;
            }

            //create new blog record
            $blog->update($data);

            return redirect()->back()->with('blogUpdatedStatus', 'Blog updated successfully');
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->user_id == Auth::user()->id) {
            Storage::delete("public/blogs/$blog->image");
            $blog->delete();
            return redirect()->back()->with('blogDeleteStatus', 'Blog Delete successfully');
        }
        abort(403);
    }

    /**
     * Display My Blogs from storage.
     */
    public function myBlogs()
    {
        $blogs = Blog::where('user_id', Auth::user()->id)->paginate(10);
        return view('theme.blogs.my-blogs', compact('blogs'));
    }
}
