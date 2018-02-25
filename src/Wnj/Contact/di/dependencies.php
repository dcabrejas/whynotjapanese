<?php

$container[\Wnj\Contact\Controller\ContactController::class] = function ($c) {
    return new \Wnj\Contact\Controller\ContactController(
        $c->get('mailer'),
        $c->get('logger'),
        $c->get(\Wnj\GeoIP\LocationProvider::class)
    );
};