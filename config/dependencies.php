<?php

$container = $millmanphotography->getContainer();

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(ROOT . DS . 'templates/');
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));
    return $view;
};

$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $container['view']->render($response->withStatus(404), '404.html');
    };
};
