<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    // استخدام ميدل وير للتحقق من الـ JWT والتأكد من الدور admin
    public function __construct()
    {
       // $this->middleware(['auth:api', 'role:admin']);
    }

    // عرض جميع المستخدمين مع أدوارهم (pagination)
    public function index()
    {
        $users = User::with('roles')->get();
        return response()->json($users);
    }

    // عرض تفاصيل مستخدم معين
    public function show($id)
    {
        $user = User::with('roles')->find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    // تحديث بيانات المستخدم
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
 
    $validator = Validator::make($request->all(), [
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

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    // مزامنة الأدوار الجديدة مع المستخدم
    $user->roles()->sync($request->roles);

    return response()->json([
        'message' => 'User updated successfully',
        'user' => $user->load('roles')
    ]);
        // $user = User::find($id);
        // if (!$user) {
        //     return response()->json(['message' => 'User not found'], 404);
        // }

        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:users,email,' . $user->id,
        //     'password' => [
        //         'sometimes',
        //         'nullable',
        //         'min:8',
        //         'confirmed',
        //         'regex:/[A-Z]/',
        //         'regex:/[0-9]/'
        //     ],
        //     'roles' => 'required|array',
        //     'roles.*' => 'exists:roles,id'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }

        // $user->name = $request->name;
        // $user->email = $request->email;

        // if ($request->filled('password')) {
        //     $user->password = Hash::make($request->password);
        // }

        // $user->save();

        // $user->roles()->sync($request->roles);

        // return response()->json(['message' => 'User updated successfully', 'user' => $user->load('roles')]);

    }

    // حذف مستخدم
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'User not found'], 404);

        // لا تسمح بحذف نفسك (الأدمن الحالي)
        if (auth('api')->id() == $user->id) {
            return response()->json(['message' => 'You cannot delete your own account'], 403);
        }

        $user->roles()->detach();
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
