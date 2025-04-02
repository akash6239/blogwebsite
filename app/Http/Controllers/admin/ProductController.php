<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function blogview()
    {
        $products = Product::orderBy('sortno','ASC')->get();
        return view('admin.pages.product.view',compact('products'));
    }
    public function productadd()
    {
        $categories = Category::orderBy('sortno','ASC')->get();
        return view("admin.pages.product.add",compact('categories'));
    }
    public function productstore(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(),[
            'sortno'          => 'required',
            'name'            => 'required|string|max:255',
            'slug'            => 'required|string|max:255|unique:products',
            'price'           => 'required|numeric',
            'discount'        => 'required|numeric',
            'rating'          => 'required|numeric',
            'tax'             => 'required|numeric',
            'packaging'       => 'required|string',
            'composition'     => 'required|string',
            'description'     => 'nullable|string',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'visual'          => 'nullable',
            'alt'             => 'nullable',
            'meta_title'      => 'nullable|string|max:255',
            'meta_keywords'   => 'nullable|string|max:255',
            'meta_description'=> 'nullable|string',
            'status'          => 'required|in:Active,Inactive',
            'category_id'     => 'required|exists:categories,id',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products','public');
        }

        $visual = [];
        if ($request->hasFile('visual')) {
           foreach ($request->file('visual') as $file) {
            $path = $file->store('visuals', 'public');
            $visual[] = $path; 
           }
           $visual = json_encode($visual);
        }else {
            $visual = null;
        }

        $product = Product::create([
            'sortno'           =>  $request->sortno,
            'name'             =>  $request->name,
            'slug'             =>  $request->slug,
            'price'            =>  $request->price,
            'discount'         =>  $request->discount,
            'rating'           =>  $request->rating,
            'tax'              =>  $request->tax,
            'packaging'        =>  $request->packaging,
            'composition'      =>  $request->composition,
            'description'      =>  $request->description,
            'alt'              =>  $request->alt,
            'meta_title'       =>  $request->meta_title,
            'meta_keywords'    =>  $request->meta_keywords,
            'meta_description' =>  $request->meta_description,
            'status'           =>  $request->status,
            'image'            =>  $imagePath,
            'visual'           =>  $visual,
        ]);

        $categoryIds = $request->category_id; 
        $product->categories()->attach($categoryIds);

        return redirect()->route('productview')->with('success','product added successfully');
    }
    public function editproduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('sortno','ASC')->get();
        return view('admin.pages.product.edit', compact('product','categories'));
    }

    public function updateproduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
    
        // Validate input fields
        $validator = Validator::make($request->all(), [
            'sortno'          => 'required',
            'name'            => 'required|string|max:255',
            'slug'            => 'required|string|max:255|unique:products,slug,' . $product->id,
            'price'           => 'required|numeric',
            'discount'        => 'required|numeric',
            'rating'          => 'required|numeric',
            'tax'             => 'required|numeric',
            'packaging'       => 'required|string',
            'composition'     => 'required|string',
            'description'     => 'nullable|string',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'visual'          => 'nullable|array',
            'visual.*'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'alt'             => 'nullable',
            'meta_title'      => 'nullable|string|max:255',
            'meta_keywords'   => 'nullable|string|max:255',
            'meta_description'=> 'nullable|string',
            'status'          => 'required|in:Active,Inactive',
            'category_id'     => 'required|array', 
            'category_id.*'   => 'exists:categories,id', 
        ]);
    
        // Return errors if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Store the old image path before any changes
        $imagePath = $product->image;
    
        // Handle image upload and deletion
        if ($request->hasFile('image')) {
            // If a new image is uploaded, delete the old one if it exists
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath); // Delete old image
            }
            // Store the new image and set the path
            $imagePath = $request->file('image')->store('products', 'public');
        }
    
        // Handle visual files (if any) and deletion
        $visual = null;
        if ($request->hasFile('visual')) {
            // If there are existing visuals, delete old ones
            if ($product->visual) {
                $existingVisuals = json_decode($product->visual);
                foreach ($existingVisuals as $existingVisual) {
                    if (Storage::disk('public')->exists($existingVisual)) {
                        Storage::disk('public')->delete($existingVisual);
                    }
                }
            }
    
            // Store the new visuals
            $visual = [];
            foreach ($request->file('visual') as $file) {
                $path = $file->store('visuals', 'public');
                $visual[] = $path;
            }
            // Convert the visual paths to a JSON string
            $visual = json_encode($visual);
        }
    
        // Update the product with the new data (image, visual, etc.)
        $product->update([
            'sortno'           =>  $request->sortno,
            'name'             =>  $request->name,
            'slug'             =>  $request->slug,
            'price'            =>  $request->price,
            'discount'         =>  $request->discount,
            'rating'           =>  $request->rating,
            'tax'              =>  $request->tax,
            'packaging'        =>  $request->packaging,
            'composition'      =>  $request->composition,
            'description'      =>  $request->description,
            'alt'              =>  $request->alt,
            'meta_title'       =>  $request->meta_title,
            'meta_keywords'    =>  $request->meta_keywords,
            'meta_description' =>  $request->meta_description,
            'status'           =>  $request->status,
            'image'            =>  $imagePath,  // Use the new image path or keep the old one
            'visual'           =>  $visual,
        ]);
    
        // Sync the categories (update the associated categories)
        $product->categories()->sync($request->category_id);
    
        // Redirect back with success message
        return redirect()->route('productview')->with('success', 'Product updated successfully');
    }

    public function deleteImage($id)
{
    $product = Product::findOrFail($id);

    // Delete the image from storage if it exists
    if ($product->image && Storage::disk('public')->exists($product->image)) {
        Storage::disk('public')->delete($product->image);
    }

    // Optionally reset the image field in the database to null
    $product->update(['image' => null]);

    // Return a JSON response
    return response()->json([
        'success' => true,
        'message' => 'Image deleted successfully'
    ]);
}

        
    


    public function deleteproduct($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
    
        if ($product->visual) {
            $visualFiles = json_decode($product->visual); 
            if (is_array($visualFiles)) {
                foreach ($visualFiles as $file) {
                    if (Storage::disk('public')->exists($file)) {
                        Storage::disk('public')->delete($file);
                    }
                }
            }
        }
    
        $product->categories()->detach();
        $product->delete();
    
        return redirect()->back()->with('success', 'Product deleted successfully');
    }
    
}
