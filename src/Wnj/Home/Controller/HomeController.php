<?php

namespace Wnj\Home\Controller;

use Wnj\Messages;
use Wnj\Contact\Form\CountryOptions;
use Slim\Csrf\Guard;
use Slim\Views\Twig;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * @author Diego Cabrejas <dcabrejas@icloud.com>
 */
class HomeController
{
    private $csrf;
    private $view;

    public function __construct(Twig $view, Guard $csrf) {
        $this->view = $view;
        $this->csrf = $csrf;
    }

    public function __invoke(Request $request, Response $response)
    {
        $vars = [
            'nameKey'   => $this->csrf->getTokenNameKey(),
            'valueKey'  => $this->csrf->getTokenValueKey(),
            'name'      => $request->getAttribute($this->csrf->getTokenNameKey()),
            'value'     => $request->getAttribute($this->csrf->getTokenValueKey()),
            'messages'  => new Messages(),
            'countries' => CountryOptions::getCountries()
        ];

        return $this->view->render($response, 'index.twig', $vars);
    }
}
