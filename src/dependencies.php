<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// mailer
$container['mailer'] = function ($c) {
    $settings = $c->get('settings')['smtp'];

    $mailer = new Wnj\Mailer(
        $settings['host'],
        $settings['username'],
        $settings['password'],
        $settings['smtpsecure'],
        $settings['port'],
        true
    );

    return $mailer;
};

// csrf
$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};
