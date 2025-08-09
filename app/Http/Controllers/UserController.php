<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
      public static function middleware(): array
    {
        return [
            new Middleware('permission:view users', only: ['index']),
            new Middleware('permission:edit users', only: ['edit']),
            // new Middleware('permission:create roles', only: ['create']),
            // new Middleware('permission:delete roles', only: ['destroy']),
        ];
    }
    public function index()
    {
        $users = User::orderBy('name','ASC')->paginate(10);
      return view('users.list',['users' => $users ]);  
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $user = User::findOrFail($id);
         $roles = Role::orderBy('name', 'ASC')->get();

         $hasRoles = $user->roles->pluck('id');
        //  dd($hasRoles);
      return view('users.edit',[
        'user' => $user, 
        'roles' => $roles,
        'hasRoles' => $hasRoles ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email, '.$id.',id'
        ]);

        if($validator->fails()) {
            return redirect()->route('users.edit', $id)->withInput()->withErrors($validator);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $user->syncRoles($request->role);
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
          
       $user = User::find($request->id);

        if($user == null){
            session()->flash('error', 'User not found');
            return response()->json([
                'status' => false
            ]);
        }
        $user->delete();
         session()->flash('success', 'User deleted successfully');
            return response()->json([
                'status' => true
            ]);

    }
}
