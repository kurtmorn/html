<?php

return [
    'name' => env('APP_NAME'),
    'logo' => '/img/logo_Halloween.png',
    'icon' => '/img/icon_Halloween.png',

    'paypal_email' => 'sb-psukd6665118@business.example.com',
    'paypal_sandbox' => true,

    'route_domains' => [
        'admin_site' => 'west.otorium.local',
        'main_site' => 'otorium.local',
        'jobs_site' => 'jobs.otorium.local'
    ],

    'storage_url' => 'http://cdn.otorium.local',
    'referral_url' => 'https://avsq.link',

    'official_thumbnail' => '/img/official-thumbnails/avasquare.png',

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
        'url' => 'http://south.otorium.local',
        'key' => 'dAktdYZ2SBABYCmK',
        'default_filename' => '40oFb9RYEBLwvzPNse3Ajh623',
        'previews_enabled' => true
    ],

    'socials' => [
        'discord' => 'https://discord.gg/n9vcmaR8Y2',
        'twitter' => '#'
    ],

    'admin_panel_code' => '',
    'maintenance_passwords' => [
        'testermanonly'
    ],

    'catalog_item_types' => ['home', 'hat', 'face', 'gadget', 'shirt', 'pants', 'crate', 'bundle'],
    'catalog_recent_item_types' => ['hat', 'face', 'gadget', 'crate', 'bundle'],
    'catalog_3d_view_types' => [],
    'inventory_item_types' => ['hat', 'face', 'gadget', 'shirt', 'pants', 'crate'],
    'character_editor_item_types' => ['hat', 'face', 'gadget', 'shirt', 'pants'],
    'item_thumbnails_with_padding' => ['hat', 'face', 'gadget', 'tshirt', 'shirt', 'pants', 'crate', 'bundle']
];
