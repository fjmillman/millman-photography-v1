<?php

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use \Slim\Container;
use \Slim\Views\Twig;
use \Slim\Views\TwigExtension;
use \MillmanPhotography\IndexController;
use \MillmanPhotography\AboutMeController;
use \MillmanPhotography\ContactMeController;

$container = $millmanphotography->getContainer();

$container['View'] = function (Container $container) {
    $view = new Twig(ROOT . DS . 'templates/');
    $view->addExtension(new TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));
    return $view;
};

$container['notFoundHandler'] = function (Container $container) {
    return function (RequestInterface $request, ResponseInterface $response) use ($container) {
        $view = $container->get('View');
        return $view->render(
            $response->withStatus(404),
            '404.html'
        );
    };
};

$container['IndexController'] = function (Container $container) {
    $view = $container->get('View');
    return new IndexController($view);
};

$container['AboutMeController'] = function (Container $container) {
    $view = $container->get('View');
    return new AboutMeController($view);
};

$container['ContactMeController'] = function (Container $container) {
    $view = $container->get('View');
    return new ContactMeController($view);
};
