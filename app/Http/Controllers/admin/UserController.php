<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function adduser()
    {
        return view('admin.pages.user.add');
    }
    public function viewuser()
    {
        $users = User::orderBy("id","desc")->where('role','user')->get();
        return view("admin.pages.user.view", compact("users"));
    }

    public function storeuser(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'nullable|string|min:8',
            'status' => 'required|in:active,inactive',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->password = Hash::make($request->password);  
        $user->save();

        return redirect()->route('viewuser')->with('success', 'User Added successfully!');
    }

    public function deleteuser($id)
    {
        $user = User::findOrFail($id);
        try{
            $user->delete();  
        }catch(\Exception $e){
            return back()->with("error", $e->getMessage());
        }
        return redirect()->route('viewuser')->with('success', 'User deleted successfully!');
    }

    public function edituser($id)
    {
        $user = User::findOrFail($id);
        return view("admin.pages.user.edit", compact("user"));
    }

    public function updateuser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'status' => 'required|in:active,inactive',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;

        // Update the password only if it's provided
        if ($request->has('password') && !empty($request->password)) {
            $user->password = Hash::make($request->password);  // Hash the password
        }

        $user->save();

        return redirect()->route('viewuser')->with('success', 'User updated successfully!');
    }

}
