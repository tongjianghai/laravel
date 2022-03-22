<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    public function show(Topic $topic)
    {

        $posts = $topic->posts()->orderBy('created_at', 'desc')->with(['user'])->take(10)->get();
        $me = Auth::user();

        $myposts = \App\Models\Post::authorBy(Auth::id())->topicNotBy($topic->id)->get();

        return view('topic/show', compact('topic', 'posts', 'myposts'));
    }

    public function submit(Topic $topic)
    {
        $this->validate(request(), [
            'post_ids' => 'array'
        ]);

        $posts = \App\Models\Post::find(request('post_ids'));
        foreach ($posts as $post) {
            if ($post->user_id != Auth::id()) {
                return back()->withErrors(array('messgae' => '没有权限'));
            }
        }

        $post_ids = request('post_ids');
        $topic_id = $topic->id;
        foreach ($post_ids as $post_id) {
            \App\Models\PostTopic::firstOrCreate(compact('topic_id', 'post_id'));
        }

        return back();
    }
}
