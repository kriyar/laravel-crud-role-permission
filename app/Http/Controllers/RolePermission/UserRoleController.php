<?php

namespace App\Http\Controllers\RolePermission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Guard;

class UserRoleController extends Controller
{

  /**
  *
  *
  * @return \Illuminate\Http\Response
  */
  function __construct()
  {
    $this->middleware('permission:Administer user role');
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index(Request $request)
  {
    $users = User::orderBy('id','DESC')->paginate(10);
    return view('role_permission.users.index', compact('users'))
    ->with('i', ($request->input('page', 1) - 1) * 10);
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit(User $user)
  {
    //dd(Guard::getNames($user)->toArray());
    if ($user->id == 1) {
      $roles = Role::orderBy('name','ASC')->whereNotIn('name', ['Super Admin', 'Authenticated'])->get();
    } else {
      $roles = Role::orderBy('name','ASC')->whereNotIn('name', ['Authenticated'])->get();
    }
    $userRoles = [];
    $userRoles_name = [];
    if (!empty($user->getRoleNames())) {
      $default = $user->getRoleNames();
      $userRoles_name = $default->toArray();
    }

    $role_options = [];
    foreach ($roles as $role) {
      $role_options['Guard ' . $role->guard_name][$role->id] = $role;
      if (in_array($role->name, $userRoles_name)) {
        $userRoles[$role->id] = TRUE;
      } else {
        $userRoles[$role->id] = FALSE;
      }
    }

    return view('role_permission.users.user-role', compact('user', 'role_options', 'userRoles'));
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, User $user)
  {
      $roles = $request['roles']; //Retrieving the roles field
      $roles[] = 3; // Always give Authenticated role to all users
      if ($user->id == 1) {
        $roles[] = 1; // Always give Super Admin role to user with ID = 1
      }

      //Checking if a role was selected
      $user_guards = Guard::getNames($user)->toArray();
      if (isset($roles)) {
        $user->syncRoles(null);
        foreach ($roles as $role_id) {
          $role = Role::find($role_id);
          if (in_array($role->guard_name, $user_guards)) {
              $user->assignRole($role);
          }
        }
      } else {
        $user->syncRoles(null);
      }

      return redirect()->route('user.list')
      ->with('success', __('User role updated successfully.'));
  }
}
