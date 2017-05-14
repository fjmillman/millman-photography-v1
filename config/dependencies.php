<?php

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Projek\Slim\Plates;
use Projek\Slim\PlatesExtension;
use MillmanPhotography\IndexController;
use MillmanPhotography\GalleryController;
use MillmanPhotography\BlogController;
use MillmanPhotography\Page;

$container = $millmanphotography->getContainer();

$container['view'] = function (Container $container) {
    $settings = [
        'directory' => ROOT . DS . 'templates/',
        'assetPath' => PUBLIC_HTML,
    ];
    $view = new Plates($settings);
    $view->loadExtension(new PlatesExtension($container['router'], $container['request']->getUri()));
    return $view;
};

$container['notFoundHandler'] = function (Container $container) {
    return function (RequestInterface $request, ResponseInterface $response) use ($container) {
        $view = $container->get('view');
        $view->setResponse($response->withStatus(404));
        return $view->render(
            '404',
            [
                'pages' => Page::getPages(),
            ]
        );
    };
};

$container[IndexController::class] = function (Container $container) {
    $view = $container->get('view');
    $galleryController = $container->get(GalleryController::class);
    $blogController = $container->get(BlogController::class);
    return new IndexController($view, $galleryController, $blogController);
};

$container[GalleryController::class] = function (Container $container) {
    $view = $container->get('view');
    return new GalleryController($view);
};

$container[BlogController::class] = function (Container $container) {
    $view = $container->get('view');
    return new BlogController($view);
};
