<?php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Projek\Slim\PlatesProvider;
use MillmanPhotography\IndexController;
use MillmanPhotography\GalleryController;
use MillmanPhotography\BlogController;

$container = $millmanphotography->getContainer();

$container->register(new PlatesProvider);

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

$container['errorHandler'] = function (Container $container) {
    return function (ServerRequestInterface $request, ResponseInterface $response, Exception $exception) use ($container) {
        $message = $exception->getMessage();
        $view = $container->get('view');
        $view->setResponse($response->withStatus(400));
        return $view->render(
            '400',
            [
                'message' => $message,
            ]
        );
    };
};

$container['notFoundHandler'] = function (Container $container) {
    return function (ServerRequestInterface $request, ResponseInterface $response) use ($container) {
        $view = $container->get('view');
        $view->setResponse($response->withStatus(404));
        return $view->render(
            '404'
        );
    };
};

$container['notAllowedHandler'] = function (Container $container) {
    return function (ServerRequestInterface $request, ResponseInterface $response) use ($container) {
        $view = $container->get('view');
        $view->setResponse($response->withStatus(405));
        return $view->render(
            '405'
        );
    };
};
