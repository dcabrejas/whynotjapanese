<?php
// DIC configuration
$container = $app->getContainer();

include __DIR__ . '/Wnj/Contact/di/dependencies.php';
include __DIR__ . '/Wnj/Mail/di/dependencies.php';
include __DIR__ . '/Wnj/Home/di/dependencies.php';
include __DIR__ . '/Wnj/GeoIP/di/dependencies.php';

// Register component on container
$container['view'] = function ($c) {
    $settings = $c->get('settings')['view'];
    $view = new Slim\Views\Twig($settings['template_path'], [
        'cache' => true
    ]);

    // Instantiate and add Slim specific extension
    //$basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $c['request']->getUri()));
    $view->addExtension(new Wnj\View\TwigExtension\Base($c, $c->get('request')));
    return $view;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// csrf
$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};
