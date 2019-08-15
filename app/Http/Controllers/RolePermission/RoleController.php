<?php

namespace App\Http\Controllers\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{

  /**
  *
  *
  * @return \Illuminate\Http\Response
  */
  function __construct()
  {
    $this->middleware('permission:Administer role|View role list', ['only' => ['index']]);
    $this->middleware('permission:Administer role|Create role', ['only' => ['create','store']]);
    $this->middleware('permission:Administer role|Edit role', ['only' => ['edit','update']]);
    $this->middleware('permission:Administer role|Delete role', ['only' => ['destroy']]);
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index(Request $request)
  {
    $roles = Role::orderBy('id','DESC')->paginate(10);
    return view('role_permission.roles.index', compact('roles'))
    ->with('i', ($request->input('page', 1) - 1) * 10);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $guards = config('auth.guards');
    $guard_name = [];
    foreach ($guards as $key => $value) {
      $guard_name[$key] = $key;
    }
    return view('role_permission.roles.create', compact('guard_name'));
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|unique:roles,name',
    ]);

    $input = $request->only('name', 'guard_name');
    $role = Role::create($input);

    return redirect()->route('roles.index')
    ->with('success', __('Role :name created successfully.', ['name' => $role->name]));
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show(Role $role)
  {
    $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
    ->where("role_has_permissions.role_id", $role->id)
    ->get();

    return view('role_permission.roles.show',compact('role','rolePermissions'));
  }


  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit(Role $role)
  {
    $guards = config('auth.guards');
    $guard_name = [];
    foreach ($guards as $key => $value) {
      $guard_name[$key] = $key;
    }

    return view('role_permission.roles.edit',compact('role', 'guard_name'));
  }


  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Role $role)
  {
    $this->validate($request, [
      'name' => ['required', Rule::unique('permissions')->ignore($role)]
    ]);

    $input = $request->only('name', 'guard_name');
    if ($input['guard_name'] != $role->guard_name) {
       $role->syncPermissions(null);
    }
    $role->update($input);

    return redirect()->route('roles.index')
    ->with('success', __('Role :name updated successfully.', ['name' => $role->name]));
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy(Role $role)
  {
    $name = $role->name;

    // Delete role
    $role->delete();

    return redirect()->route('roles.index')
    ->with('success', __('Role :name is successfully deleted.', ['name' => $name]));
  }

}
