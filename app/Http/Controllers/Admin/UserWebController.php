<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
class UserWebController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => [
                'nullable',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[0-9]/'
            ],
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $user->roles()->sync($request->roles);

        return redirect()->route('admin.users')->with('success', 'تم تحديث بيانات المستخدم.');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting admin itself
        if (auth()->id() == $id) {
            return redirect()->back()->with('error', 'You cannot delete your own account');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }
}
