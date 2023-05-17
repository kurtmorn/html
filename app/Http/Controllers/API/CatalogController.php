<?php

namespace App\Http\Controllers\API;

use App\Models\Item;
use App\Models\CrateItem;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller
{
    public function search(Request $request)
    {
        $json = [];
        $error = ($request->category != 'recent') ? "No {$request->category} found." : 'There are no recent items.';
        $type = lcfirst(itemTypeFromPlural($request->category));

        if (!empty($request->search))
            $error = 'This search returned no results.';

        if (!in_array($type, config('site.catalog_item_types')))
            return response()->json(['error' => 'Invalid category.']);

        if ($type != 'recent')
            $items = Item::where([
                ['name', 'LIKE', "%{$request->search}%"],
                ['type', '=', $type],
                ['status', '=', 'approved'],
                ['public_view', '=', true]
            ]);
        else
            $items = Item::where([
                ['name', 'LIKE', "%{$request->search}%"],
                ['status', '=', 'approved'],
                ['public_view', '=', true]
            ])->whereIn('type', config('site.catalog_recent_item_types'));

        if ($items->count() == 0)
            return response()->json(['error' => $error]);

        $items = $items->orderBy('updated_at', 'DESC')->paginate(12);

        foreach ($items as $item)
            $json[] = [
                'name'      => (string) $item->name,
                'type'      => (string) $item->type,
                'thumbnail' => (string) $item->thumbnail(),
                'price'     => (integer) $item->price,
                'onsale'    => (boolean) $item->onsale(),
                'limited'   => (boolean) $item->limited,
                'timed'     => (boolean) $item->isTimed(),
                'stock'     => (integer) $item->stock,
                'url'       => (string) route('catalog.item', [$item->id, $item->slug()]),
                'creator'   => [
                    'username' => (string) $item->creatorName(),
                    'image'    => (string) $item->creatorImage(),
                    'url'      => (string) $item->creatorUrl()
                ]
            ];

        return response()->json(['current_page' => $items->currentPage(), 'total_pages' => $items->lastPage(), 'items' => $json]);
    }

    public function openCrate(Request $request)
    {
        $crate = Item::where([
            ['id', '=', $request->id],
            ['type', '=', 'crate']
        ]);

        if (!$crate->exists())
            return response()->json(['error' => 'This crate does not exist.']);

        if (!Auth::user()->ownsItem($request->id))
            return response()->json(['error' => 'You do not own this crate.']);

        $crate = $crate->first();
        $crateItems = $crate->CrateItems();

        if (empty($crateItems))
            return response()->json(['error' => 'This crate is empty so your crate has been preserved. We apologize.']);

        $winningItemId = CrateItem::getWinningItem($crate->id);
        $winningItem = CrateItem::where('id', '=', $winningItemId)->first();

        Inventory::where([
            ['user_id', '=', Auth::user()->id],
            ['item_id', '=', $crate->id]
        ])->first()->delete();

        $inventory = new Inventory;
        $inventory->user_id = Auth::user()->id;
        $inventory->item_id = $winningItem->item->id;
        $inventory->save();

        $images = [];

        foreach ($crateItems as $crateItem)
            $images[$crateItem['id']] = [
                'id'      => (integer) $crateItem['id'],
                'src'     => (string) $crateItem['thumbnail'],
                'color'   => (string) crateRarity('color', $crateItem['rarity']),
                'padding' => (string) itemTypePadding($crateItem['type'])
            ];

        for ($i = 0; $i < 50; $i++) {
            $itemImages = [];
            $id = rand();

            shuffle($crateItems);

            foreach ($crateItems as $crateItem)
                $itemImages[$id] = [
                    'id'      => (integer) $id,
                    'src'     => (string) $crateItem['thumbnail'],
                    'color'   => (string) crateRarity('color', $crateItem['rarity']),
                    'padding' => (string) itemTypePadding($crateItem['type'])
                ];

            shuffle($itemImages);

            $images[$id] = $itemImages[0];
        }

        shuffle($images);

        $winningIndex = floor(count($images) * 0.5) + 1;
        $images[$winningIndex] = [
            'id'      => (integer) $winningItem->id,
            'src'     => (string) $winningItem->item->thumbnail(),
            'color'   => (string) crateRarity('color', $winningItem->rarity),
            'padding' => (string) itemTypePadding($winningItem->item->type)
        ];

        $animateLeft = ($winningIndex - 2) * 153.3;

        return response()->json([
            'id'              => (integer) $winningItem->id,
            'name'            => (string) $winningItem->item->name,
            'thumbnail'       => (string) $winningItem->item->thumbnail(),
            'url'             => (string) route('catalog.item', [$winningItem->item->id, $winningItem->item->slug()]),
            'padding'         => (string) itemTypePadding($winningItem->item->type),
            'unboxing_images' => (array) $images,
            'animate_left'    => (string) "-={$animateLeft}px",
            'rarity' => [
                'name' => CrateItem::rarityName($winningItem->rarity),
                'color' => CrateItem::rarityColor($winningItem->rarity)
            ]
        ]);
    }
}
