<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('address')) {
            $query->where('address', 'like', '%' . $request->address . '%');
        }
        return response()->json([
            'success' => true,
            'data'    => $query->get(),
            'params'  => $request->all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), User::rules());
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();
        // Handle image upload
        if ($request->hasFile('image')) {
            // Store the file in the 'public/images' directory
            $path = $request->file('image')->store('images', 'public');
            // Save only the file name to the database
            $validatedData['image'] = basename($path);
        }

        $user = User::create($validatedData);
        return response()->json(['success' => true, 'data' => $user], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return response()->json(['success' => true, 'data' => User::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), User::rules());
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'data not found']);
        }
        $validatedData = $validator->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validatedData['image'] = basename($path);
        }

        $user->update($validatedData);
        return response()->json(['success' => true, 'data' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'data not found']);
        }
        $user->delete();
        return response()->json(['success' => true, 'data' => $user]);
    }
}
