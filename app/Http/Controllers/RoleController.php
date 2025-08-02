<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\models\Permission;
use Spatie\Permission\models\Role;

class RoleController extends Controller
{
    public function index() {
      return view('roles.list');  
    }
    public function create()
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('roles.create', ['permissions' => $permissions]);
    }
    public function store(Request $request) {
         $validator = Validator::make($request->all(),[
        'name' => 'required|unique:roles|min:3'
      ]);

      if($validator->passes()){
        // dd($request->permission);
       $role = Role::create(['name' => $request->name ]);
        
        if(!empty($request->permission)){
            foreach ($request->permission as $name){
                $role->givePermissionTo($name);
            }
        }
        return redirect()->route('roles.index')->with('success','Role added successfully.' );
      }else {
        return redirect()->route('roles.create')->withInput()->withErrors($validator);
      }
    }
    public function delete() {

    }
}
