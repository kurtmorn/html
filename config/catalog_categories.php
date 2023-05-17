<?php

/**
 * is_visible: Show category on the catalog home page
 * official_only: Only show items uploaded to the system account
 * limiteds_only: Only show limited items
 * name_like: Item names need to include a specific string
 * item_ids: Only show these specific items in the category
 */

$recentTypes = ['hat', 'face', 'gadget', 'crate', 'bundle'];

return [
    [
        'is_visible' => true,
        'official_only' => true,
        'limiteds_only' => false,
        'title' => 'Crates',
        'name_like' => null,
        'item_types' => [],
        'item_ids' => [
            7
        ]
    ],
    [
        'is_visible' => true,
        'official_only' => true,
        'limiteds_only' => false,
        'title' => 'Recently Released',
        'name_like' => null,
        'item_types' => $recentTypes,
        'item_ids' => []
    ],
    [
        'is_visible' => true,
        'official_only' => true,
        'limiteds_only' => false,
        'title' => 'Trendy Hair Styles',
        'name_like' => 'hair',
        'item_types' => ['hat'],
        'item_ids' => []
    ],
    [
        'is_visible' => true,
        'official_only' => false,
        'limiteds_only' => true,
        'title' => 'Collectible Items',
        'name_like' => null,
        'item_types' => $recentTypes,
        'item_ids' => []
    ],
    [
        'is_visible' => false,
        'official_only' => false,
        'limiteds_only' => false,
        'title' => 'Featured User Creations',
        'name_like' => null,
        'item_types' => [],
        'item_ids' => []
    ]
];
