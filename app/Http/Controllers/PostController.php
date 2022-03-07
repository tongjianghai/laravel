<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class PostController extends Controller
{
    public function index()
    {
        $posts = [];
        return view('post/index', compact('posts'));
    }

    public function show()
    {
        return view('post/show');
    }

    public function create()
    {
        return view('post/create');
    }

    public function edit()
    {
        return view('post/edit');
    }

    public function update()
    {
        return 0;
    }

    public function delete()
    {
        return 0;
    }
}
