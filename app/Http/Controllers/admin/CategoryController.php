<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function viewcategory()
    {
        $categories = Category::orderBy('id','DESC')->get();
        return view('admin.pages.category.view',compact('categories'));
    }
    public function addcategory()
    {
        return view("admin.pages.category.add");
    }
    public function storecategory(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'            => 'required|string|max:255',
            'slug'            => 'required|string|max:255|unique:categories',
            'title'           => 'nullable|string',
            'menu'           =>  'nullable',
            'meta_title'      => 'nullable|string|max:255',
            'meta_keywords'   => 'nullable|string|max:255',
            'meta_description'=> 'nullable|string',
            'status'          => 'required|in:active,inactive',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

            Category::create([
            'name'            => $request->name,
            'slug'            => $request->slug,
            'title'           => $request->title,
            'menu'            => $request->menu,
            'meta_title'      => $request->meta_title,
            'meta_keywords'   => $request->meta_keywords,
            'meta_description'=> $request->meta_description,
            'status'          => $request->status,
        ]);

       return redirect()->route('viewcategory')->with('success','category created successfully');
    }

    public function editcategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.pages.category.edit',compact('category'));
    }

    public function updatecategory(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'            => 'required|string|max:255',
            'slug'            => 'required|string|max:255|unique:categories,slug,' . $id,
            'title'           => 'nullable|string',
            'menu'           =>  'nullable',
            'meta_title'      => 'nullable|string|max:255',
            'meta_keywords'   => 'nullable|string|max:255',
            'meta_description'=> 'nullable|string',
            'status'          => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = Category::findOrFail($id);

        $category->update([
            'name'            => $request->name,
            'slug'            => $request->slug,
            'title'           => $request->title,
            'menu'            => $request->menu,
            'meta_title'      => $request->meta_title,
            'meta_keywords'   => $request->meta_keywords,
            'meta_description'=> $request->meta_description,
            'status'          => $request->status,
        ]);
        return redirect()->route('viewcategory')->with('success', 'Category updated successfully');
    }


    public function deletecategory($id)
    {
        $category = Category::findOrFail($id);
        try{
            $category->delete();
        }catch(Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    
        return redirect()->route('viewcategory')->with('success', 'Category deleted successfully!');
    }
}
