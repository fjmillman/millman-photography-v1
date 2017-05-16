<?php

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\PDO\Database;
use Projek\Slim\Plates;
use Projek\Slim\PlatesExtension;
use MillmanPhotography\Controller\IndexController;
use MillmanPhotography\Controller\GalleryController;
use MillmanPhotography\Controller\BlogController;
use MillmanPhotography\Repository\BlogRepository;
use MillmanPhotography\Repository\GalleryRepository;
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

$container[IndexController::class] = function (Container $container) {
    $view = $container->get('view');
    $galleryController = $container->get(GalleryController::class);
    $blogController = $container->get(BlogController::class);
    return new IndexController($view, $galleryController, $blogController);
};
