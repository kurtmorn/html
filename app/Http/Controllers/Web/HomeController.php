<?php

namespace App\Http\Controllers\Web;

use App\Models\Item;
use App\Models\Inventory;
use App\Models\Status;
use App\Models\ForumThread;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('web.home.index');
    }

    public function dashboard()
    {
        $friends = [];
        $updates = ForumThread::where([
            ['topic_id', '=', config('site.updates_forum_topic_id')],
            ['is_deleted', '=', false]
        ])->orderBy('created_at', 'DESC')->get()->take(5);

        foreach (Auth::user()->friends() as $friend)
            $friends[] = $friend->id;

        $statuses = Status::where([
            ['creator_id', '!=', Auth::user()->id],
            ['message', '!=', null]
        ])->whereIn('creator_id', $friends)->orderBy('created_at', 'DESC')->take(10)->get();

        return view('web.home.dashboard')->with([
            'updates' => $updates,
            'statuses' => $statuses
        ]);
    }

    public function admin()
    {
        $item = config('site.fake_admin_item_id');

        if (!$item) abort(404);

        $item = Item::where('id', '=', $item)->firstOrFail();

        if (!Auth::user()->ownsItem($item->id)) {
            $inventory = new Inventory;
            $inventory->user_id = Auth::user()->id;
            $inventory->item_id = $item->id;
            $inventory->save();
        }

        return redirect()->route('catalog.item', [$item->id, $item->slug()]);
    }
    public function status(Request $request)
    {
        $this->validate($request, [
            'message' => ['max:124']
        ]);

        if ($request->message != Auth::user()->status()) {
            $status = new Status;
            $status->creator_id = Auth::user()->id;
            $status->message = $request->message;
            $status->save();
        }

        return back()->with('success_message', 'Status has been changed.');
    }
}
