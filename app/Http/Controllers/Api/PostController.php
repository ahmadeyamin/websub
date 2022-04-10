<?php

namespace App\Http\Controllers\Api;

use App\Models\Website;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $domain)
    {
        // return $request->input('title');

        $website = Website::where('domain', $domain)->first();

        if (!$website) {
            return response()->json([
                'message' => 'Website not found'
            ], 404);
        }

        // return request()->all();

        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $post = $website->posts()->create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post
        ], 200);

        
    }

    
}
