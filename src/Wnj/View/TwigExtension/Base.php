<?php

declare(strict_types=1);

namespace Wnj\View\TwigExtension;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author Diego Cabrejas <dcabrejas@icloud.com>
 */
class Base extends \Twig_Extension
{
    /**
     * @var array
     */
    private $settings;

    /**
     * @var ServerRequestInterface
     */
    private $request;

    public function __construct(
        ContainerInterface $conatiner,
        ServerRequestInterface $request
    ) {
        $this->settings = $conatiner->get('settings');
        $this->request = $request;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('twitter_url', array($this, 'getTwitterUrl')),
            new \Twig_SimpleFunction('google_maps_url', array($this, 'getGoogleMapsUrl')),
            new \Twig_SimpleFunction('asset_url', array($this, 'getAssetUrl'))
        ];
    }

    public function getTwitterUrl() : string
    {
        return $this->settings['links']['twitter_url'] ?? '';
    }

    public function getGoogleMapsUrl() : string
    {
        return $this->settings['links']['google_maps_url'] ?? '';
    }

    public function getAssetUrl(string $relativePath) : string
    {
        return sprintf(
            'assets/%s',
            ltrim($relativePath, '/')
        );
    }
}
