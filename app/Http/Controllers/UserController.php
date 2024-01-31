<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return response()->json([
                'success' => ['status' => 'OK', 'code' => 200, 'msg' => 'No Users Yet', 'data' => []],
                'errors' => [],
            ]);
        }

        return response()->json([
            'success' => ['status' => 'OK', 'code' => 200, 'msg' => 'Success get all data users', 'data' => $users],
            'errors' => [],
        ]);
    }

    // Eloquent ORM store method
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed|min:5|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => [],
                'errors' => ['status' => 'Bad Request', 'code' => 400, 'msg' => $validator->errors()],
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'success' => ['status' => 'Created', 'code' => 201, 'msg' => 'Success create new User', 'data' => $user],
            'errors' => [],
        ], 201);
    }

    // Query Builder store method
    public function storeWithQueryBuilder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed|min:5|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => [],
                'errors' => ['status' => 'Bad Request', 'code' => 400, 'msg' => $validator->errors()],
            ], 400);
        }

        $user = DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'success' => ['status' => 'Created', 'code' => 201, 'msg' => 'Success create new User with Query Builder', 'data' => $user],
            'errors' => [],
        ], 201);
    }

    // ... (existing methods)

    // Query Builder destroy method
    public function destroyWithQueryBuilder($id)
    {
        $user = DB::table('users')->find($id);

        if (!$user) {
            return response()->json([
                'success' => [],
                'errors' => ['status' => 'Not Found', 'code' => 404, 'msg' => 'User not found'],
            ], 404);
        }

        DB::table('users')->where('id', $id)->delete();

        return response()->json([
            'success' => ['status' => 'OK', 'code' => 200, 'msg' => 'User deleted successfully with Query Builder'],
        ]);
    }
}