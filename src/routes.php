<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Wnj\Contact\Controller\ContactController;
use Wnj\Home\Controller\HomeController;

//home
$app->get('/', HomeController::class)->setName('home');

//contact
$app->post('/contact/post', ContactController::class)->setName('contact');

//terms and conditions
$app->get('/terms-and-conditions', function (Request $request, Response $response) {
    return $this->view->render($response, 'terms.twig', []);
})->setName('terms');
//end terms and conditions

//blog
$app->get('/blog', function (Request $request, Response $response) {
    $vars = [];
    return $this->view->render($response, 'blog', $vars); //todo create blog
})->setName('blog');
//end blog
