<?php

use RKA\Session;
use Slim\Container;
use Projek\Slim\Plates;
use Projek\Slim\Monolog;
use Slim\Csrf\Guard as Csrf;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Projek\Slim\PlatesExtension;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Resource\ContactResource;
use MillmanPhotography\Controller\BlogController;
use MillmanPhotography\Controller\IndexController;
use MillmanPhotography\Validator\ContactValidator;
use MillmanPhotography\Controller\GalleryController;
use MillmanPhotography\Controller\ContactController;
use MillmanPhotography\Middleware\CsrfTokenProvider;

$container = $millmanphotography->getContainer();

$container[Monolog::class] = function (Container $container) {
    $settings = $container->get('settings')['logger'];
    return new Monolog($settings['name'], $settings['settings']);
};

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

$container[EntityManager::class] = function (Container $container) {
    $settings = $container->get('settings');
    $config = Setup::createAnnotationMetadataConfiguration(
        $settings['doctrine']['meta']['entity_path'],
        $settings['doctrine']['meta']['auto_generate_proxies'],
        $settings['doctrine']['meta']['proxy_dir'],
        $settings['doctrine']['meta']['cache'],
        false
    );
    return EntityManager::create($settings['doctrine']['connection'], $config);
};

$container[IndexController::class] = function (Container $container) {
    $view = $container->get(Plates::class);
    $galleryController = $container->get(GalleryController::class);
    $blogController = $container->get(BlogController::class);
    return new IndexController($view, $galleryController, $blogController);
};

$container[GalleryController::class] = function (Container $container) {
    $entityManager = $container->get(EntityManager::class);
    $view = $container->get(Plates::class);
    return new GalleryController($entityManager, $view);
};

$container[BlogController::class] = function (Container $container) {
    $entityManager = $container->get(EntityManager::class);
    $view = $container->get(Plates::class);
    return new BlogController($entityManager, $view);
};

$container[ContactController::class] = function (Container $container) {
    $validator = $container->get(ContactValidator::class);
    $resource = $container->get(ContactResource::class);
    $logger = $container->get(Monolog::class);
    return new ContactController($validator, $resource, $logger);
};

$container[ContactValidator::class] = function (Container $container) {
    return new ContactValidator();
};

$container[ContactResource::class] = function (Container $container) {
    $entityManager = $container->get(EntityManager::class);
    return new ContactResource($entityManager);
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
