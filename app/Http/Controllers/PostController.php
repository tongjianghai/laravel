<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(3);
        return view('post/index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('post/show', compact('post'));
    }

    public function create()
    {
        return view('post/create');
    }

    public function store(Request $request)
    {
        // $post = new Post();
        // $post->title = request('title');
        // $post->content = request('content');
        // $post->save();

        // $params = ['title' => request('title'), 'content' => request('content')];
        // $params = request(['title', 'content']);

        $this->validate($request, [
            'title' => 'required|string|max:100|min:5',
            'content' => 'required|string|min:10',
        ]);
        $post = Post::create(request(['title', 'content']));
        // $post = Post::create(['title' => request('title'), 'content' => request('content')]);
        return redirect('posts');
        // dd($post);
        // dd(request()->all());
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

    public function imageUpload(Request $request)
    {
        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset('storage/' . $path);
        // dd($request->all());
    }
}
