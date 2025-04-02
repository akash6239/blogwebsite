<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('webapp.pages.index');
    }
    public function aboutus()
    {
        return view('webapp.pages.about');
    }
    public function teams()
    {
        return view('webapp.pages.teams');
    }
    public function gallery()
    {
        return view('webapp.pages.gallery');
    }
    public function blog()
    {
        $posts = Post::orderBy('id', 'DESC')
             ->where('status', 'active') 
             ->where('is_published', 'yes')
             ->paginate(30);
        return view('webapp.pages.blog',compact('posts'));
    }
    public function contact()
    {
        return view('webapp.pages.contact');
    }

    public function blogdetail(Request $request ,$slug)
    {
        $query = Post::query();
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%')
                  ->orWhereHas('tags', function ($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }
    
        // Get the filtered posts
        $posts = $query->where('status', 'active')
                       ->where('is_published', 'yes')
                       ->orderBy('id', 'DESC')
                       ->paginate(10);

        $post = Post::where('slug',$slug)
        ->where('status', 'active') 
        ->where('is_published', 'yes')->first();

        $currentPostCategories = $post->categories->pluck('id')->toArray();

        $getrecentpost = Post::where('status', 'active') 
        ->where('is_published', 'yes')->orderBy('id','DESC')->limit(3)->get();

        $getrelatedpost = Post::where('status', 'active') 
        ->where('is_published', 'yes')
        ->whereNotIn('id', [$post->id]) 
        ->whereHas('categories', function ($query) use ($currentPostCategories) {
            $query->whereNotIn('categories.id', $currentPostCategories); 
        })
        ->orderBy('id', 'DESC')
        ->limit(3)
        ->get();

        $category = Category::where('status', 'active')->orderBy('id','DESC')->get();

        $tags =  $post->tags()->where('status', 'active')->orderBy('id', 'DESC')->paginate(10);
        
        if($post){
            return view('webapp.pages.blogdetail',compact('post','category','getrecentpost','tags','posts'));
        }else{
            abort(404);
        }
    }
}
