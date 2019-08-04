<?php

namespace App\Http\Controllers\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{

  /**
  *
  *
  * @return \Illuminate\Http\Response
  */
  function __construct()
  {
    $this->middleware('permission:Administer role permission');
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $assign_filter_role_id = session('assign_filter_role_id');
    $assign_filter_group = session('assign_filter_group');
    $assign_filter_guard_name = session('assign_filter_guard_name');

    $role_header = [];
    if (!empty($assign_filter_role_id)) {
      $role_header = Role::orderBy('name','ASC')->where('name', '<>', 'Super Admin')->whereIn('id', $assign_filter_role_id)->pluck('name', 'id')->all();
    }

    session(['selected_roles' => $role_header]);

    $data = [];
    if (!empty($assign_filter_guard_name) and !empty($assign_filter_group)) {
      $data = Permission::orderBy('group','ASC')->whereIn('guard_name', $assign_filter_guard_name)->whereIn('group', $assign_filter_group)->get();
    }

    $permissions = [];
    $rolePermissions = [];
    foreach($data as $permission) {
      $permissions[$permission->group][$permission->id] = $permission;

      foreach ($role_header as $role_id => $role_name) {
          $role_permission = $role_id . '_' . $permission->id;
          $role = Role::where('id', '=', $role_id)->first();
          $rolePermissions[$role_permission] = $role->hasPermissionTo($permission->name);
      }
    }
    session(['selected_permissions' => $data]);

    $role_options = [];
    $role_data = Role::orderBy('guard_name','ASC')->where('name', '<>', 'Super Admin')->get();
    foreach ($role_data as $info) {
      $role_options['Guard ' . $info->guard_name][$info->guard_name . '_' . $info->id] = $info->name;
    }

    $group_options = [];
    $permission_data = Permission::orderBy('guard_name','ASC')->get();
    foreach ($permission_data as $info) {
      $group_options['Guard ' . $info->guard_name][$info->guard_name . '_' . $info->group] = $info->group;
    }

    return view('role_permission.index', compact('role_options', 'group_options', 'role_header', 'permissions', 'rolePermissions'));
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    $all = $request->all();
    unset($all['_token']);

    $selected_roles = session('selected_roles');
    $selected_permissions = session('selected_permissions');

    foreach ($selected_permissions as $permission) {
      foreach($selected_roles as $role_id => $role_name) {
         $role_permission = $role_id . '_' . $permission->id;
         if (in_array($role_permission, $all)) {
           $role = Role::where('id', '=', $role_id)->first();
           $permission->assignRole($role); //Assigning role to permission
         } else {
           $permission->removeRole($role_name); //Remove role from permission
         }
      }
    }

    return redirect()->route('role.permission')
    ->with('success', __('Permission successfully saved.'));
  }

  /*
  *  Delete all related sessions
  *
  */
  protected function deleteSession() {
    session()->forget('assign_filter_role_id');
    session()->forget('selected_filter_role_id');
    session()->forget('assign_filter_group');
    session()->forget('selected_filter_group');
    session()->forget('assign_filter_guard_name');
    session()->forget('selected_roles');
    session()->forget('selected_permissions');
  }

  /**
  * Register profile
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function assignFilter(Request $request)
  {
    $roles = $request->input('roles');
    $groups = $request->input('groups');

    if (empty($roles) or empty($groups)) {
      $this->deleteSession();
      return redirect()->back()->with('warning', __('Please select at least one value from both Role and Group'));
    }

    $guard_roles = [];
    $selected_roles = [];
    foreach($roles as $role) {
      list($guard, $role_id) = explode('_', $role);
      $guard_roles[$guard] = $guard;
      $selected_roles[$role_id] = $role_id;
    }

    if (count($guard_roles) > 1) {
       $this->deleteSession();
       return redirect()->route('role.permission')->with('warning', __('Please select the role only in the same guard name.'));
    }

    $guard_permissions = [];
    $selected_groups = [];
    foreach($groups as $group) {
      list($guard, $group_name) = explode('_', $group);
      $guard_permissions[$guard] = $guard;
      $selected_groups[$group_name] = $group_name;
    }

    if (count($guard_permissions) > 1) {
       $this->deleteSession();
       return redirect()->route('role.permission')->with('warning', __('Please select the group only in the same guard name.'));
    }

    $guard_role_permission = array_diff($guard_roles, $guard_permissions);
    if (empty($guard_role_permission)) {
       $guard_role_permission = array_diff($guard_permissions, $guard_roles);
    }

    if (!empty($guard_role_permission)) {
       $this->deleteSession();
       return redirect()->route('role.permission')->with('warning', __('You cannot select role and permission in different guard name.'));
    }

    session(['assign_filter_role_id' => $selected_roles]);
    session(['assign_filter_group' => $selected_groups]);
    session(['assign_filter_guard_name' => $guard_roles]);
    session(['selected_filter_role_id' => $roles]);
    session(['selected_filter_group' => $groups]);
    return redirect()->route('role.permission');
  }
}
