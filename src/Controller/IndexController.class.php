<?php

namespace MillmanPhotography;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;

class IndexController
{
    private $view;

    public function __construct(Container $container)
    {
        $this->view = $container->get('View');
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response)
    {
        $image = [
            Config::IMAGE_ROOT . ImageConfig::NORTHUMBERLAND . ImageConfig::EXT_JPEG,
            Config::IMAGE_ROOT . ImageConfig::ROSEBERRY_TOPPING . ImageConfig::EXT_JPEG,
            Config::IMAGE_ROOT . ImageConfig::BATH . ImageConfig::EXT_JPEG,
            Config::IMAGE_ROOT . ImageConfig::ASHNESS_JETTY . ImageConfig::EXT_JPEG,
            Config::IMAGE_ROOT . ImageConfig::DURDLE_DOOR . ImageConfig::EXT_JPEG,
            Config::IMAGE_ROOT . ImageConfig::KERNOW . ImageConfig::EXT_JPEG,
            Config::IMAGE_ROOT . ImageConfig::SWALEDALE . ImageConfig::EXT_JPEG,
        ];

        return $this->view->render(
            $response->withStatus(200),
            'index.html',
            ['title' => Page::MILLMAN_PHOTOGRAPHY, 'image' => $image]
        );
    }
}
