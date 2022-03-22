<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::withoutGlobalScope('available')->where('status', 0)->orderBy('created_at', 'desc')->paginate(10);
        return view('/admin/post/index', compact('posts'));
    }

    /*
     * 修改文章的状态
     */
    public function status(Post $post)
    {
        $this->validate(request(), [
            "status" => 'required|in:-1,1',
        ]);

        $post->status = request('status');
        $post->save();
        return [
            'error' => 0,
            'msg' => ''
        ];
    }
}
