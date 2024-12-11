<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $user->update([
            'is_active' => $request->boolean('is_active'),
        ]);

        return response()->json([
            'message' => 'User updated successfully',
        ]);
    }
}
