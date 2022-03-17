<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function setting()
    {
        return view('user.setting');
    }

    public function settingStore()
    {
        return null;
    }

    public function show(User $user)
    {
        $user = User::withCount(['stars', 'fans', 'posts'])->find($user->id);

        $posts = $user->posts()->orderBy('created_at', 'desc')->take(10)->get();

        $stars = $user->stars()->get();

        $fans = $user->fans()->get();

        return view('user/show', compact('user', 'posts', 'stars', 'fans'));
    }

    public function fan(User $user)
    {
        $me = Auth::user();
        $me->doFan($user->id);
        return [
            'error' => 0,
            'msg' => ''
        ];
    }

    public function unfan(User $user)
    {
        $me = Auth::user();
        $me->doUnfan($user->id);
        return [
            'error' => 0,
            'msg' => ''
        ];
    }
}
