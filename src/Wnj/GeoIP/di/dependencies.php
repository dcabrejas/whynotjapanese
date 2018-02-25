<?php

$container[\Wnj\GeoIp\LocationProvider::class] = function ($c) {
    return new \Wnj\GeoIp\LocationProvider(
        $c->get('request'),
        $c->get('logger')
    );
};