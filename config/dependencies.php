<?php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\PDO\Database;
use Projek\Slim\PlatesProvider;
use MillmanPhotography\Controller\IndexController;
use MillmanPhotography\Controller\GalleryController;
use MillmanPhotography\Controller\BlogController;
use MillmanPhotography\Controller\ContactController;
use MillmanPhotography\Repository\BlogRepository;
use MillmanPhotography\Repository\GalleryRepository;

$container = $millmanphotography->getContainer();

$container->register(new PlatesProvider);

$container['db'] = function (Container $container) {
    $settings = $container->get('settings');
    $dsn = 'mysql:host=' . $settings['db']['host']
        . ';dbname=' . $settings['db']['name']
        . ';charset=' . $settings['db']['char'];
    $user = $settings['db']['user'];
    $pass = $settings['db']['pass'];
    return new Database($dsn, $user, $pass);
};

$container[GalleryRepository::class] = function (Container $container) {
    $db = $container->get('db');
    return new BlogRepository($db);
};

$container[BlogRepository::class] = function (Container $container) {
    $db = $container->get('db');
    return new BlogRepository($db);
};

$container[GalleryController::class] = function (Container $container) {
    $repository = $container->get(GalleryRepository::class);
    $view = $container->get('view');
    return new GalleryController($repository, $view);
};

$container[BlogController::class] = function (Container $container) {
    $repository = $container->get(BlogRepository::class);
    $view = $container->get('view');
    return new BlogController($repository, $view);
};

$container[ContactController::class] = function (Container $container) {
    $view = $container->get('view');
    return new ContactController($view);
};

$container[IndexController::class] = function (Container $container) {
    $view = $container->get('view');
    $galleryController = $container->get(GalleryController::class);
    $blogController = $container->get(BlogController::class);
    return new IndexController($view, $galleryController, $blogController);
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
