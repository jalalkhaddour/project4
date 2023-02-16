<?php

return [
    'activated'        =>true, // active/inactive all logging
    'middleware'       => ['guest','J4Auth','guest','api','web', 'auth'],
    'delete_limit'     => 2920, //  8 years =2920 days


    'log_events' => [
        'on_create'     => true,
        'on_edit'       => true,
        'on_delete'     => true,
        'on_login'      => true,
        'on_lockout'    => true
    ]
];
