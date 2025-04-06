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
        // Initialize the query for posts
        $query = Post::orderBy('id', 'DESC')
            ->where('status', 'active')
            ->where('is_published', 'yes');
        
        // Check if a search term exists
        if (request()->has('search') && !empty(request()->search)) {
            $searchTerm = request()->search;
            
            // Sanitize the search term (just an extra precaution)
            $searchTerm = trim($searchTerm);
            
            // Apply search to both title and tags
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('tags', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%');
                });
            });
        }
        
        // Paginate the results, 30 posts per page
        $posts = $query->paginate(30);
        
        // Return the view with the posts
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

            if ($getcategorypost->isNotEmpty()) {
                $firstPost = $getcategorypost->first();
                $data['meta_title'] = $firstPost->meta_title;
                $data['meta_keywords'] = $firstPost->meta_keywords;
                $data['meta_description'] = $firstPost->meta_description;
            }
    
            return view('webapp.pages.categoryblog', compact('getcategorypost','data','getcategory'));
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
                $data['meta_title'] = $post->meta_title;
                $data['meta_keywords'] = $post->meta_keywords;
                $data['meta_description'] = $post->meta_description;

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
            
                return view('webapp.pages.blogdetail', compact('post', 'category', 'getrecentpost', 'tags','data'));
            } else {
                abort(404);
            }
    }
}
