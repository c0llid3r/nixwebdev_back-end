<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function postlist () {
        return Post::all();
    }

    public function store (Request $request) {
        $fileName = str_replace(' ', '_', $request->title);
        $webp = $request->file(key: 'webp')->storeAs('blogimages', $fileName . '.webp', 's3');
        $request->file(key: 'png')->storeAs('blogimages', $fileName . '.png', 's3');
        $imgPath = substr($webp, 11, -5);

        Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'keywords' => $request->keywords,
            'image' => $imgPath
        ]);

        return redirect('/');
    }
}
