<?php

use Wnj\Home\Controller\HomeController;

$container[HomeController::class] = function ($c) {
    return new HomeController($c->get('view'), $c->get('csrf'));
};