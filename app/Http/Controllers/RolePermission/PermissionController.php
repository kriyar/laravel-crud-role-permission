<?php

namespace App\Http\Controllers\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{

  /**
  *
  *
  * @return \Illuminate\Http\Response
  */
  function __construct()
  {
    $this->middleware('permission:Administer permission|View permission list', ['only' => ['index']]);
    $this->middleware('permission:Administer permission|Create permission', ['only' => ['create','store']]);
    $this->middleware('permission:Administer permission|Edit permission', ['only' => ['edit','update']]);
    $this->middleware('permission:Administer permission|Delete permission', ['only' => ['destroy']]);
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index(Request $request)
  {
    $permissions = Permission::orderBy('group','ASC')->paginate(10);
    return view('role_permission.permissions.index', compact('permissions'))
    ->with('i', ($request->input('page', 1) - 1) * 10);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $role = Role::orderBy('name','ASC')->pluck('name', 'id');
    $guards = config('auth.guards');
    $guard_name = [];
    foreach ($guards as $key => $value) {
      $guard_name[$key] = $key;
    }
    return view('role_permission.permissions.create', compact('role', 'guard_name'));
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
      'name' => 'required|unique:permissions,name',
      'group' => 'required'
    ]);

    $input = $request->only('name', 'guard_name', 'group');
    $permission = Permission::create($input);

    return redirect()->route('permissions.index')
    ->with('success', __('Permission :name created successfully.', ['name' => $permission->name]));
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show(Permission $permission)
  {
    $rolePermissions = Role::join("role_has_permissions","role_has_permissions.role_id","=","roles.id")
    ->where("role_has_permissions.permission_id", $permission->id)
    ->get();

    return view('role_permission.permissions.show',compact('permission','rolePermissions'));
  }


  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit(Permission $permission)
  {
    $guards = config('auth.guards');
    $guard_name = [];
    foreach ($guards as $key => $value) {
      $guard_name[$key] = $key;
    }

    return view('role_permission.permissions.edit',compact('permission', 'guard_name'));
  }


  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Permission $permission)
  {
    $this->validate($request, [
      'name' => ['required', Rule::unique('permissions')->ignore($permission)],
      'group' => 'required'
    ]);

    $input = $request->only('name', 'guard_name', 'group');
    if ($input['guard_name'] != $permission->guard_name) {
       $permission->syncRoles(null);
    }
    $permission->update($input);

    return redirect()->route('permissions.index')
    ->with('success', __('Permission :name updated successfully.', ['name' => $permission->name]));
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy(Permission $permission)
  {
    $name = $permission->name;

    // Delete permission
    $permission->delete();

    return redirect()->route('permissions.index')
    ->with('success', __('Permission :name is successfully deleted.', ['name' => $name]));
  }
}
