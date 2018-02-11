<?php
return [
    'settings' => [
        'displayErrorDetails' => false, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // View settings
        'view' => [
            'template_path' => __DIR__ . '/../templates/',
            'cache_path'    => __DIR__ . '/../cache/',
        ],

        // Links
        'links' => [
            'twitter_url' => 'https://twitter.com/maki_japanese',
            'google_maps_url' => 'https://www.google.co.uk/maps/place/Why+not+Japanese/@52.9547757,-1.1471684,17z/data=!3m1!4b1!4m5!3m4!1s0x4879c17e217924f5:0xdb873f2d1f8995f2!8m2!3d52.9547757!4d-1.1449797?hl=en'
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        //SMTP settings
        'smtp' => [
            'host' => 'whynotjapanese.com',
            'username' => 'maki@whynotjapanese.com',
            'password' => '2nxvQ!GgT7fH',
            'smtpsecure' => 'ssl',
            'port' => '465'
        ],
    ],
];
