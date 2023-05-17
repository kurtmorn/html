<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\Group;
use App\Models\Friend;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UsernameHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $search = (isset($request->search)) ? trim($request->search) : '';

        if (Str::startsWith($search, '%'))
            $search = '';

        $users = User::where('username', 'LIKE', "%{$search}%")->orderBy('updated_at', 'DESC')->paginate(12);
        $total = User::all()->count();

        return view('web.users.index')->with([
            'search' => $search,
            'users' => $users,
            'total' => $total
        ]);
    }

    public function profile($username)
    {
        $user = User::where('username', '=', $username);

        if (!$user->exists()) {
            $usernameHistory = UsernameHistory::where('username', '=', $username);

            if (!$usernameHistory->exists()) abort(404);

            return redirect()->route('users.profile', $usernameHistory->first()->user->username);
        }

        $user = $user->first();
        $friends = $user->friends()->take(6);
        $groups = $user->groups()->take(6);

        if (Auth::check()) {
            $friendsArray = [];

            foreach ($user->friends() as $friend)
                $friendsArray[] = $friend->id;

            $areFriends = in_array(Auth::user()->id, $friendsArray);
            $isPending = Friend::where('is_pending', '=', true)->where(function($query) use($user) {
                $query->where([
                    ['receiver_id', '=', $user->id],
                    ['sender_id', '=', Auth::user()->id]
                ])->orWhere([
                    ['receiver_id', '=', Auth::user()->id],
                    ['sender_id', '=', $user->id]
                ]);
            })->first();
        }

        return view('web.users.profile')->with([
            'user' => $user,
            'friends' => $friends,
            'groups' => $groups,
            'areFriends' => $areFriends ?? false,
            'isPending' => $isPending ?? false
        ]);
    }

    public function friends($username)
    {
        $user = User::where('username', '=', $username)->firstOrFail();
        $friendsArray = [];

        foreach ($user->friends() as $friend)
            $friendsArray[] = $friend->id;

        $friends = User::whereIn('id', $friendsArray)->paginate(24);

        return view('web.users.friends')->with([
            'user' => $user,
            'friends' => $friends
        ]);
    }

    public function groups($username)
    {
        $user = User::where('username', '=', $username)->firstOrFail();
        $groupsArray = [];

        foreach ($user->groups() as $group)
            $groupsArray[] = $group->id;

        $groups = Group::whereIn('id', $groupsArray)->paginate(24);

        return view('web.users.groups')->with([
            'user' => $user,
            'groups' => $groups
        ]);
    }
}
