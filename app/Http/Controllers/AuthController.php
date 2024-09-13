<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'line_id' => 'required|string',
        ]);
        $user = User::where('line_id', $validated['line_id'])->first();
        if ($user === null) {
            $user = User::create($validated);
            $role_platinum = Role::where('name', 'platinum')->first();
            $user->assignRole([$role_platinum]);
        }

        $token = $user->createToken('apiToken', [])->plainTextToken;

        return response()->json(['token' => $token], Response::HTTP_OK);
    }
}
