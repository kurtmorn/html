<?php

namespace App\Http\Controllers\Web;

use App\Models\Item;
use App\Models\Group;
use App\Models\GroupRank;
use App\Models\Inventory;
use App\Models\GroupMember;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AssetChecksum;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class CreatorAreaController extends Controller
{
    public function index(Request $request)
    {
        $isGroup = $request->has('t') && $request->t == 'group';
        $price = config('site.group_creation_price');
        $title = (!$isGroup) ? 'Create Item' : 'Create Space';

        if ($request->has('gid')) {
            $group = Group::where([
                ['id', '=', $request->gid],
                ['owner_id', '=', Auth::user()->id]
            ]);

            $groupId = ($group->exists()) ? $request->gid : 0;
        }

        return view('web.creator_area.index')->with([
            'isGroup' => $isGroup,
            'price' => $price,
            'groupId' => $groupId ?? 0,
            'title' => $title
        ]);
    }

    public function create(Request $request)
    {
        $isGroup = $request->has('is_group');
        $price = config('site.group_creation_price');
        $filename = Str::random(50);
        $dimensions = (!$isGroup && $request->type != 'tshirt') ? 'dimensions:min_width=1024,max_height=1024,min_height=1024,max_height=1024' : 'dimensions:min_width=100,min_height=100';
        $validate = [
            'name' => ['required', 'min:3', 'max:70', 'regex:/^[a-z0-9 .\-!,\':;<>?()\[\]+=\/]+$/i'],
            'description' => ['max:1024'],
            'template' => ['required', $dimensions, 'mimes:png,jpg,jpeg', 'max:2048']
        ];

        if ($isGroup) {
            $ranks = [
                255 => 'Owner',
                254 => 'Admin',
                1   => 'Member'
            ];

            $validate['name'][] = 'unique:groups';
            $this->validate($request, $validate, [
                'template.dimensions' => 'The logo has invalid image dimensions.'
            ]);

            if (Auth::user()->currency < $price)
                return back()->withErrors(["You need at least {$price} currency to create a space."]);

            if (Auth::user()->reachedGroupLimit())
                return back()->withErrors(['You have reached the limit of groups you can be apart of.']);

            $group = new Group;
            $group->owner_id = Auth::user()->id;
            $group->name = $request->name;
            $group->description = $request->description;
            $group->thumbnail_url = $filename;
            $group->save();

            foreach ($ranks as $rank => $name) {
                $groupRank = new GroupRank;
                $groupRank->group_id = $group->id;
                $groupRank->name = $name;
                $groupRank->rank = $rank;
                $groupRank->save();
            }

            $groupMember = new GroupMember;
            $groupMember->user_id = Auth::user()->id;
            $groupMember->group_id = $group->id;
            $groupMember->rank = 255;
            $groupMember->save();

            $user = Auth::user();
            $user->currency -= $price;
            $user->save();

            $logo = imagecreatefromstring($request->file('template')->get());
            $img = imagecreatetruecolor(420, 420);

            imagealphablending($img, false);
            imagesavealpha($img, true);
            imagefilledrectangle($img, 0, 0, 420, 420, imagecolorallocatealpha($img, 255, 255, 255, 127));
            imagecopyresampled($img, $logo, 0, 0, 0, 0, 420, 420, imagesx($logo), imagesy($logo));

            $logo = $img;
            imagealphablending($logo, false);
            imagesavealpha($logo, true);

            Storage::put("thumbnails/{$filename}.png", Image::make($logo)->encode('png'));

            return redirect()->route('groups.view', [$group->id, $group->slug()])->with('success_message', 'Space has been created.');
        } else {
            if (!in_array($request->type, ['tshirt', 'shirt', 'pants'])) abort(404);

            if ($request->has('group_id')) {
                $group = Group::where([
                    ['id', '=', $request->group_id],
                    ['owner_id', '=', Auth::user()->id]
                ]);

                $groupId = ($group->exists()) ? $request->group_id : 0;
            }

            $onsale = $request->has('onsale');

            if (!isset($groupId)) {
                $creatorId = Auth::user()->id;
                $creatorType = 'user';
            } else {
                $creatorId = $groupId;
                $creatorType = 'group';
            }

            if ($onsale)
                $validate['price'] = ['required', 'numeric', 'min:0', 'max:1000000'];

            $this->validate($request, $validate);

            $hash = md5_file($request->file('template'));
            $checksum = AssetChecksum::where('hash', '=', "{$request->type}_{$hash}");

            $item = new Item;
            $item->creator_id = $creatorId;
            $item->creator_type = $creatorType;
            $item->name = $request->name;
            $item->description = $request->description;
            $item->type = $request->type;
            $item->price = ($onsale) ? $request->price : 0;
            $item->onsale = $onsale;
            $item->filename = $filename;

            if ($checksum->exists()) {
                $checksum = $checksum->first();

                $item->status = $checksum->item->status;
                $item->filename = $checksum->item->filename;
                $item->thumbnail_url = $checksum->item->thumbnail_url;
            }

            $item->save();

            if ($checksum->exists()) {
                $inventory = new Inventory;
                $inventory->user_id = Auth::user()->id;
                $inventory->item_id = $item->id;
                $inventory->save();
            } else {
                if ($item->type != 'tshirt') {
                    Storage::putFileAs('uploads', $request->file('template'), "{$filename}.png");
                } else {
                    $tshirt = imagecreatefromstring($request->file('template')->get());
                    $img = imagecreatetruecolor(420, 420);

                    imagealphablending($img, false);
                    imagesavealpha($img, true);
                    imagefilledrectangle($img, 0, 0, 420, 420, imagecolorallocatealpha($img, 255, 255, 255, 127));
                    imagecopyresampled($img, $tshirt, 0, 0, 0, 0, 420, 420, imagesx($tshirt), imagesy($tshirt));

                    $tshirt = $img;
                    imagealphablending($tshirt, false);
                    imagesavealpha($tshirt, true);

                    Storage::put("uploads/{$filename}.png", Image::make($tshirt)->encode('png'));
                }
            }

            return redirect()->route('catalog.item', [$item->id, $item->slug()])->with('success_message', 'Item has been created and is currently awaiting approval.');
        }
    }
}
