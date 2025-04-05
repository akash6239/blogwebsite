<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Request;

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
        // Start the query builder for posts
        $query = Post::orderBy('id', 'DESC')
            ->where('status', 'active')
            ->where('is_published', 'yes');
    
        // Check if the search query parameter exists and is not empty
        if (request()->has('search') && !empty(request()->search)) {
            $searchTerm = request()->search;
    
            // Filter the posts based on the search term
            $query->where('title', 'like', '%' . $searchTerm . '%')
                //   ->orWhere('content', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('tags', function ($q) use ($searchTerm) {
                      $q->where('name', 'like', '%' . $searchTerm . '%');
                  });
        }
    
        // Paginate the results
        $posts = $query->paginate(30);
    
        // Return the view with the filtered posts
        return view('webapp.pages.blog', compact('posts'));
    }

    public function categoryblog($slug)
    {
        $getcategory =  Category::where('slug', $slug)->first();
         // category post
         $getcategorypost = Post::whereHas('categories',function($query)use($getcategory){
            $query->where('category_id',$getcategory->id);
           })->orderBy('id', 'DESC')
            ->where('status', 'active')
            ->where('is_published', 'yes')->paginate(30);
            // dd($getcategorypost);
    
            return view('webapp.pages.categoryblog', compact('getcategorypost'));
    }
    


    public function contact()
    {
        return view('webapp.pages.contact');
    }

    public function blogdetail(Request $request ,$slug)
    {
                            // slug post
            $post = Post::where('slug',$slug)
            ->where('status', 'active') 
            ->where('is_published', 'yes')->first();

            if ($post) {
                $currentPostCategories = $post->categories->pluck('id')->toArray();
                $getrecentpost = Post::where('status', 'active') 
                    ->where('is_published', 'yes')
                    ->orderBy('id','DESC')
                    ->limit(3)
                    ->get();
            
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
            
                $tags = $post->tags()->where('status', 'active')->orderBy('id', 'DESC')->paginate(10);
            
                return view('webapp.pages.blogdetail', compact('post', 'category', 'getrecentpost', 'tags'));
            } else {
                abort(404);
            }
    }
}
