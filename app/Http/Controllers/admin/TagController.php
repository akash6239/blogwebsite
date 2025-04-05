<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function viewtag()
    {
        $tags = Tag::orderBy('id','DESC')->get();
        return view("admin.pages.tag.view",compact('tags'));
    }

    public function addtag()
    {
        return view("admin.pages.tag.add");
    }
    public function storetag(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'name'            => 'required|unique:tags,name',
            'status'           => 'required|in:active,inactive',
        ]);
    
        try {
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            $tag = new Tag;
            $tag->name    = $request->name;
            $tag->status  = $request->status;
            $tag->save();
    
            return redirect()->route('viewtag')->with('success', 'Tag created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function edittag($id)
    {
        $tag = Tag::findOrFail($id);
        return view('admin.pages.tag.edit',compact('tag'));
    }

    public function updatetag(Request $request,$id)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'name'            => 'required|unique:tags,name,'.$id,
            'status'           => 'required|in:active,inactive',
        ]);
            $tag = Tag::findOrFail($id);
    
        try {
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            $tag->name     = $request->name;
            $tag->status   = $request->status;
            $tag->save();
    
            return redirect()->route('viewtag')->with('success', 'Tag updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function deletetag($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();
    
        return redirect()->route('viewtag')->with('success', 'Tag deleted successfully!');
    }
}
