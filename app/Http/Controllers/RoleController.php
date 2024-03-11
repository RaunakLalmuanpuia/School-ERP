<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
   

    // Role
    //Role Index
    public function roles()
     {
        $roles = Role::with('permissions')->get();
         return Inertia::render('Role/Role', [
             'roles' => $roles
         ]);
     }

     public function storeRole(Request $request){
         // dd($request);
         $request->validate([
             'name' => ['required', 'string'],
             'permissions' => ['array'],
         ]);

         $role = Role::create(['name' => $request->input('name')]);

         $role->givePermissionTo($request->input('permissions'));

         return redirect()->route('roles');
     }

     public function editRole(Role $role)
     {
         $permissions = Permission::pluck('name', 'id');

         return view('PermissionsUI::roles.edit', compact('role', 'permissions'));
     }
     public function updateRole(Request $request, Role $role)
     {
        //  dd($role);
         $request->validate([
             'name' => ['required', 'string'],
             'permissions' => ['array'],
         ]);

         $role->update(['name' => $request->input('name')]);

         $role->syncPermissions($request->input('permissions'));

         return redirect()->route('roles');
     }
     public function destroyRole(Role $role)
     {
         // dd($role);
         $role->delete();
         return redirect()->route('roles');
     }
     

     // Apply roles to users
     
     
     public function users(Request $request)
     {
        // dd(Auth()->user()->hasRole('admin'));
        $roles = Role::pluck('name', 'id');
        $users = User::query()
        ->when($request->input('search'),function($query, $search){
            $query->where('name', 'like', "%{$search}%");
            $query->orwhere('email', 'like', "%{$search}%");
            // $query->orwhere('roles', 'like', "%{$search}%");
        })
        ->with('roles')
        ->select('id','name', 'email')
        ->paginate(10)
        ->withQueryString();
         return Inertia::render('Role/User', [
             'users' => $users,
             'roles' => $roles,
             'filters' => $request->only(['search'])
         ]);
     }

     public function updateUserRole(Request $request, User $user)
     {
        $request->validate([
             'roles' => ['array'],
         ]);
         $user = User::find($request->selectedUser);
         $user->syncRoles($request->roles);
         return redirect()->route('usersRole');
     }
}
