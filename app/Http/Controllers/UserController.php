<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // $users = User::paginate(10);
        $users = User::when($request->name, function ($query, $name) {
            $query->where("name", "like", "%" . $name . "%")
                ->orWhere("email", "like", "%" . $name . "%");
        })
            ->paginate(10);
        return view("pages.users.index", compact("users"));
    }

    public function create()
    {
        return view("pages.users.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8",
            'role' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();

        return redirect()->route("users.index")->with("success", "User Created Successfully");
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view("pages.users.edit", compact("user"));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email",
            'role' => 'required',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        return redirect()->route("users.index")->with("success", "User Updated Successfully");
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route("users.index")->with("success", "User Deleted Successfully");
    }
}
