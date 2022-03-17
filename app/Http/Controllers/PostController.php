<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Zan;
use Illuminate\Http\Request;
use \Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    public function index()
    {
        Log::info('post index', ['id' => 'id']);
        $posts = Post::orderBy('created_at', 'desc')->withCount(['comments', 'zans'])->paginate(3);
        return view('post/index', compact('posts'));
    }

    public function show(Post $post)
    {
        $post->load('comments');
        return view('post/show', compact('post'));
    }

    public function create()
    {
        return view('post/create');
    }

    public function search()
    {
        $this->validate(request(), [
            "query" => "required",
        ]);

        $query = request('query');
        $posts = Post::search($query)->paginate(10);

        return view('post/search', compact('posts', 'query'));
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
        $user_id = Auth::id();
        $params = array_merge(request(['title', 'content']), compact('user_id'));
        $post = Post::create($params);
        // $post = Post::create(['title' => request('title'), 'content' => request('content')]);
        return redirect('posts');
        // dd($post);
        // dd(request()->all());
    }

    public function edit(Post $post)
    {
        return view('post/edit', compact('post'));
    }

    public function update(Post $post)
    {
        $this->validate(request(), [
            'title' => 'required|string|max:100|min:5',
            'content' => 'required|string|min:10',
        ]);

        $this->authorize('update', $post);

        $post->title = request('title');
        $post->content = request('content');
        $post->save();
        return redirect("/posts/{$post->id}");
    }

    public function delete(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect('/posts');
    }

    public function imageUpload(Request $request)
    {
        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset('storage/' . $path);
        // dd($request->all());
    }

    public function comment(Post $post)
    {
        $this->validate(request(), [
            'content' => 'required|min:3',
        ]);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->content = request('content');
        $post->comments()->save($comment);

        return back();
    }

    public function zan(Post $post)
    {
        $param = [
            'user_id' => Auth::id(),
            'post_id' => $post->id,
        ];
        Zan::firstOrCreate($param);
        return back();
    }

    public function unzan(Post $post)
    {
        $post->zan(Auth::id())->delete();
        return back();
    }
}
