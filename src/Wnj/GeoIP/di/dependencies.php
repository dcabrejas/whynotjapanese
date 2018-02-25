<?php

$container[\Wnj\GeoIP\LocationProvider::class] = function ($c) {
    return new \Wnj\GeoIP\LocationProvider(
        $c->get('request'),
        $c->get('logger')
    );
};