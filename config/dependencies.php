<?php

use RKA\Session;
use Slim\Container;
use Projek\Slim\Plates;
use Projek\Slim\Monolog;
use Slim\Csrf\Guard as Csrf;
use Slim\PDO\Database as PDO;
use Projek\Slim\PlatesExtension;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Middleware\CsrfTokenProvider;
use MillmanPhotography\Controller\BlogController;
use MillmanPhotography\Repository\BlogRepository;
use MillmanPhotography\Controller\IndexController;
use MillmanPhotography\Validator\ContactValidator;
use MillmanPhotography\Controller\GalleryController;
use MillmanPhotography\Repository\GalleryRepository;
use MillmanPhotography\Repository\ContactRepository;
use MillmanPhotography\Controller\ContactController;

$container = $millmanphotography->getContainer();

$container[Session::class] = function (Container $container) {
    return new Session();
};

$container[Csrf::class] = function (Container $container) {
    $csrf = new Csrf($container->get(Monolog::class));
    $csrf->setFailureCallable(function (Request $request, Response $response, callable $next) use ($container, $csrf) {
        $view = $container->get(Plates::class);
        $view->setResponse($response->withStatus(418));
        return $view->render(
            'error',
            [
                'code' => '418',
                'title' => 'I\'m A Teapot',
                'message' => 'There was an attempt to brew coffee with a teapot.',
            ]
        );
    });
    return $csrf;
};

$container[CsrfTokenProvider::class] = function (Container $container) {
    return new CsrfTokenProvider(
        $container->get(Plates::class),
        $container->get(Csrf::class)
    );
};

$container[Plates::class] = function (Container $container) {
    $view = new Plates($container->get('settings')['plates']);
    $view->loadExtension(new PlatesExtension($container['router'], $container['request']->getUri()));
    return $view;
};

$container[IndexController::class] = function (Container $container) {
    $view = $container->get(Plates::class);
    $galleryController = $container->get(GalleryController::class);
    $blogController = $container->get(BlogController::class);
    return new IndexController($view, $galleryController, $blogController);
};

$container[GalleryController::class] = function (Container $container) {
    $repository = $container->get(GalleryRepository::class);
    $view = $container->get(Plates::class);
    return new GalleryController($repository, $view);
};

$container[BlogController::class] = function (Container $container) {
    $repository = $container->get(BlogRepository::class);
    $view = $container->get(Plates::class);
    return new BlogController($repository, $view);
};

$container[ContactController::class] = function (Container $container) {
    $validator = $container->get(ContactValidator::class);
    $repository = $container->get(ContactRepository::class);
    $logger = $container->get(Monolog::class);
    return new ContactController($validator, $repository, $logger);
};

$container[PDO::class] = function (Container $container) {
    $settings = $container->get('settings');
    $dsn = 'mysql:host=' . $settings['db']['host']
        . ';dbname=' . $settings['db']['name']
        . ';charset=' . $settings['db']['charset'];
    $user = $settings['db']['username'];
    $pass = $settings['db']['password'];
    return new PDO($dsn, $user, $pass);
};

$container[GalleryRepository::class] = function (Container $container) {
    $db = $container->get(PDO::class);
    return new GalleryRepository($db);
};

$container[BlogRepository::class] = function (Container $container) {
    $db = $container->get(PDO::class);
    return new BlogRepository($db);
};

$container[ContactRepository::class] = function (Container $container) {
    $db = $container->get(PDO::class);
    return new ContactRepository($db);
};

$container[ContactValidator::class] = function (Container $container) {
    return new ContactValidator();
};

$container[Monolog::class] = function (Container $container) {
    $settings = $container->get('settings')['logger'];
    return new Monolog($settings['name'], $settings['settings']);
};

$container['errorHandler'] = function (Container $container) {
    return function (Request $request, Response $response, Exception $exception) use ($container) {
        $logger = $container->get(Monolog::class);
        $logger->log(100, $exception->getMessage());
        $view = $container->get(Plates::class);
        $view->setResponse($response->withStatus(400));
        return $view->render(
            'error',
            [
                'code' => '400',
                'title' => 'Bad Request',
                'message' => 'Get in touch with me to find out why this is happening.',
            ]
        );
    };
};

$container['notFoundHandler'] = function (Container $container) {
    return function (Request $request, Response $response) use ($container) {
        $view = $container->get(Plates::class);
        $view->setResponse($response->withStatus(404));
        return $view->render(
            'error',
            [
                'code' => '404',
                'title' => 'Page Not Found',
                'message' => 'I am afraid that page does not exist. Click on my logo above to go to my home page.',
            ]
        );
    };
};

$container['notAllowedHandler'] = function (Container $container) {
    return function (Request $request, Response $response, array $allowedMethods) use ($container) {
        $logger = $container->get(Monolog::class);
        $message = $allowedMethods[1];
        $logger->log(100, $message);
        $view = $container->get(Plates::class);
        $view->setResponse($response->withStatus(405));
        return $view->render(
            'error',
            [
                'code' => '405',
                'title' => 'Not Allowed',
                'message' => 'Uh oh! I don\'t think you were allowed to do that.',
            ]
        );
    };
};
