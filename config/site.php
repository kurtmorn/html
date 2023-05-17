<?php

return [
    'name' => env('APP_NAME'),
    'logo' => '/img/favicon.png',
    'icon' => '/img/favicon.png',

    'paypal_email' => 'user48029@gmail.com',
    'paypal_sandbox' => false,

    'route_domains' => [
        'admin_site' => 'west.avatoria.com',
        'main_site' => 'www.avatoria.com',
        'jobs_site' => 'jobs.avatoria.com'
    ],

    'storage_url' => 'http://cdn.avatoria.com',
    'referral_url' => 'https://avsq.link',

    'official_thumbnail' => '/img/official-thumbnails/favicon.png',

    'updates_forum_topic_id' => 1,

    'username_change_price' => 250,
    'group_creation_price' => 50,

    'flood_time' => 15,

    'daily_currency' => 10,
    'daily_currency_membership' => 25,
    'group_limit' => 10,
    'group_limit_membership' => 25,

    'donator_item_id' => 0,
    'membership_item_id' => 0,
    'email_verification_item_id' => 0,
    'fake_admin_item_id' => 0,

    'membership_name' => 'Gold',
    'membership_color' => '#000',
    'membership_bg_color' => '#ffc113',

    'renderer' => [
        'url' => 'http://xml.avatoria.com/',
        'key' => 'dAktdYZ2SBABYCmK',
        'default_filename' => 'default',
        'previews_enabled' => true
    ],

    'socials' => [
        'discord' => 'https://discord.gg/n9vcmaR8Y2',
        'twitter' => '#'
    ],

    'admin_panel_code' => '',
    'maintenance_passwords' => [
        'Avatoriateamonly'
    ],

    'catalog_item_types' => ['home', 'hat', 'face', 'gadget', 'shirt', 'pants', 'crate', 'bundle'],
    'catalog_recent_item_types' => ['hat', 'face', 'gadget', 'crate', 'bundle'],
    'catalog_3d_view_types' => [],
    'inventory_item_types' => ['hat', 'face', 'gadget', 'shirt', 'pants', 'crate'],
    'character_editor_item_types' => ['hat', 'face', 'gadget', 'shirt', 'pants'],
    'item_thumbnails_with_padding' => ['hat', 'face', 'gadget', 'tshirt', 'shirt', 'pants', 'crate', 'bundle']
];
