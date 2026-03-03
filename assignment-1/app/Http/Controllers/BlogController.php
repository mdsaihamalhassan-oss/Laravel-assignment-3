<?php
namespace App\Http\Controllers;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category')->get();
        return view('blog.index', compact('blogs'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'=>'required',
            'title'=>'required',
            'description'=>'required',
            'image'=>'required|image'
        ]);

        $img = time().'.'.$request->image->extension();
        $request->image->move(public_path('uploads/blog'), $img);

        Blog::create([
            'category_id'=>$request->category_id,
            'title'=>$request->title,
            'description'=>$request->description,
            'image'=>$img,
            'status'=>0
        ]);

        return redirect()->route('blogs.index');
    }

    public function show(Blog $blog)
    {
        return view('blog.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        $categories = Category::all();
        return view('blog.edit', compact('blog','categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $blog->update($request->only('category_id','title','description'));
        return redirect()->route('blogs.index');
    }

    public function toggleStatus(Blog $blog)
    {
        $blog->update(['status'=>!$blog->status]);
        return back();
    }
}
