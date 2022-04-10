<?php

namespace App\Http\Controllers\Api;

use App\Models\Website;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function store(Request $request, $domain)
    {
        $website = Website::where('domain', $domain)->first();

        if (!$website) {
            return response()->json([
                'message' => 'Website not found'
            ], 404);
        }

        $request->validate([
            'email' => 'required|email',
            // 'password' => 'required|min:6'
        ]);

        $user = $website->users()->firstOrCreate([
            'email' => $request->email,
        ]);

        $user->websites()->syncWithoutDetaching([$website->id]);

        return response()->json([
            'message' => 'User successfully subscribed to website',
            // 'user' => $user
        ], 200);


    }
}
