<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = DB::select('SELECT * FROM users ORDER BY name');
        return response()->json([
            'data' => $user
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
    }

    public function register(StoreUserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->status = 'Active';
        $user->save();

        return response()->json([
            'data' => $user
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        return response()->json([
            'data' => $user
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);
        if($request->name){
            $user->name = $request->name;
        }
        if($request->email){
            $user->email = $request->email;
        }
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json([
            'data' => $user->fresh()
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if($user->status === 'Active'){
            $user->status = 'Inactive';
        }else{
            $user->status = 'Active';
        }
        $user->save();

        return response()->json([
            'message' => 'successfully change status'
        ],200);
    }

    public function getUserByStatus(string $status){
        $user = User::where('status', $status)
                    ->orderBy('name')
                    ->get();
        return response()->json([
            'data'=> $user
        ],200);
    }
    public function getUserByStatusExceptCurrent(string $status, string $id){
        $user = User::where('status', $status)
                    ->whereNot('id', $id)
                    ->orderBy('name')
                    ->get();
        return response()->json([
            'data'=> $user
        ],200);
    }

    public function getAllUserExceptCurrent(string $id){
        $users = DB::select("SELECT * FROM users WHERE NOT id = '$id'");
        return response()->json([
            'data' => $users
        ],200);

    }
    public function getUserByName(string $name, string $id){
        $users = DB::select("SELECT * FROM users WHERE name LIKE '%$name%' AND NOT id = $id");
        return response()->json([
            'data' => $users
        ],200);
    }
    public function getUserByStatusAndName(string $status, string $name, string $id){
        $users = DB::select("SELECT * FROM users WHERE name LIKE '%$name%' AND status = '$status' AND NOT id = $id");
        return response()->json([
            'data' => $users
        ],200);
    }

    public function getCurrentUser() {
        $user = auth()->user();
        return response()->json([
            'data' => $user
        ],200);
    }
}
