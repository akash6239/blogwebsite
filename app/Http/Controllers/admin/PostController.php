<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function viewpost()
    {
        $posts = Post::orderBy('id','DESC')->get();
        return view("admin.pages.post.view",compact('posts'));
    }

    public function addpost()
    {
        $categories = Category::orderBy('id','desc')->get();
        $tags = Tag::orderBy('id','desc')->get();
        return view('admin.pages.post.add',compact('categories','tags'));
    }

    public function storepost(Request $request)
    {
        // dd( $request->all());
        $validator = Validator::make($request->all(), [
            'title'            => 'required|string|max:255',
            'slug'             => 'required|string|max:255|unique:posts',
            'content'          => 'nullable|string',
            'excerpt'          => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alt'              => 'nullable|string|max:255',
            'meta_title'       => 'nullable|string|max:255',
            'meta_keywords'    => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'user_id'          => 'exists:users,id',
            'is_published'     => 'required|in:yes,no',
            'category_id'      => 'required|array',
            'category_id.*'    => 'exists:categories,id',
            'tag_id'           => 'required|array',
            'tag_id.*'         => 'exists:tags,id',
            'status'           => 'required|in:active,inactive',
        ]);
        
        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $destinationPath = public_path('uploads/posts');
                $fileName = time() . $image->getClientOriginalExtension();
                $image->move($destinationPath, $fileName);
                $imagePath = 'uploads/posts/' . $fileName;
            }
            
            $categoryIds = $request->category_id;
            $tagIds = $request->tag_id;
            
            $post = Post::create([
                'title'            => $request->title,
                'slug'             => $request->slug,
                'content'          => $request->content,
                'excerpt'          => $request->excerpt,
                'image'            => $imagePath,
                'alt'              => $request->alt,
                'meta_title'       => $request->meta_title,
                'meta_keywords'    => $request->meta_keywords,
                'meta_description' => $request->meta_description,
                'user_id'          => $request->user_id,
                'is_published'     => $request->is_published,
                'status'           => $request->status,
            ]);
            
            // Attach categories and tags to the post
            $post->categories()->sync($categoryIds);
            $post->tags()->sync($tagIds);
            
            return redirect()->route('viewpost')->with('success', 'Post created successfully');
            
            
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function editpost($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::orderBy('id','desc')->get();
        $tags = Tag::orderBy('id','desc')->get();
        return view('admin.pages.post.edit',compact('post','categories','tags'));
    }

    public function updatepost(Request $request, $id)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'title'            => 'required|string|max:255',
            'slug'             => 'required|string|max:255|unique:posts,slug,' . $id, // Correct unique validation
            'content'          => 'nullable|string',
            'excerpt'          => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alt'              => 'nullable|string|max:255', // Added string validation for alt
            'meta_title'       => 'nullable|string|max:255',
            'meta_keywords'    => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'user_id'          => 'exists:users,id',
            'is_published'     => 'required|in:yes,no', // Added specific options for is_published
            'category_id'      => 'required|array', 
            'category_id.*'    => 'exists:categories,id',
            'tag_id'           => 'required|array', 
            'tag_id.*'         => 'exists:tags,id',
            'status'           => 'required|in:active,inactive',
        ]);
    
        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        try {
            // Find the post to update
            $post = Post::findOrFail($id);
    
            // Check if an image was uploaded and handle it
            if ($request->hasFile('image')) {
                // Delete the old image if exists
                if ($post->image && file_exists(public_path($post->image))) {
                    unlink(public_path($post->image));
                }
    
                // Upload the new image
                $image = $request->file('image');
                $destinationPath = public_path('uploads/posts');
                $fileName = time() . '_' . $image->getClientOriginalName();
                $image->move($destinationPath, $fileName);
                $post->image = 'uploads/posts/' . $fileName; // Save the path to the image
            }
    
            // Update post details
            $post->title            = $request->title;
            $post->slug             = $request->slug;
            $post->content          = $request->content;
            $post->excerpt          = $request->excerpt;
            $post->alt              = $request->alt;
            $post->meta_title       = $request->meta_title;
            $post->meta_keywords    = $request->meta_keywords;
            $post->meta_description = $request->meta_description;
            $post->user_id          = $request->user_id;
            $post->is_published     = $request->is_published;
            $post->status           = $request->status;
    
            // Save the updated post
            $post->save(); 
    
            // Sync categories and tags
            $post->categories()->sync($request->category_id);
            $post->tags()->sync($request->tag_id);
    
            // Redirect with success message
            return redirect()->route('viewpost')->with('success', 'Post updated successfully!');
            
        } catch (\Exception $e) {
            // Return error message on failure
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function deletepost($id)
    {
        try {
            $post = Post::findOrFail($id);
    
            if ($post->image && file_exists(public_path($post->image))) {
                unlink(public_path($post->image));
            }
    
            $post->categories()->detach();
            $post->tags()->detach();
            $post->delete();
    
            return redirect()->route('viewpost')->with('success', 'Post deleted successfully!');
            
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    
}
