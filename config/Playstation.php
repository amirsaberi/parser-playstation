<?php

return [
    'parser' => [
        'name'          => 'PlayStation',
        'enabled'       => true,
        'sender_map'    => [
            '/no-reply@sie.sony.com/',
            '/rtabuse-general@shatel.ir/',
        ],
        'body_map'      => [
            //
        ],
        'aliases'       => [
        ],
    ],

    'feeds' => [
        'login-attack' => [
            'class'     => 'HACK_ATTACK',
            'type'      => 'ABUSE',
            'enabled'   => true,
            'fields'    => [
                'Report-Type',
                'Source',
                'Date',
            ],
        ],
    ],
];
