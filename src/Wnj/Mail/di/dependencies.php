<?php

// mailer
$container['mailer'] = function ($c) {
    $settings = $c->get('settings')['smtp'];

    $mailer = new Wnj\Mail\Mailer(
        $settings['host'],
        $settings['username'],
        $settings['password'],
        $settings['smtpsecure'],
        $settings['port'],
        true
    );

    return $mailer;
};