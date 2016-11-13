<?php
return [
    'permAdminPanel' => [
        'type' => 2,
        'description' => 'Admin panel',
    ],
    'permAdminRoot' => [
        'type' => 2,
        'description' => 'Admin root',
    ],
    'user' => [
        'type' => 1,
        'description' => 'User',
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Admin',
        'children' => [
            'user',
            'permAdminPanel',
        ],
    ],
    'root' => [
        'type' => 1,
        'description' => 'Root',
        'children' => [
            'admin',
            'permAdminRoot',
        ],
    ],
];
