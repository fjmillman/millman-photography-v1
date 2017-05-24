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

use MillmanPhotography\Resource\UserResource;
use MillmanPhotography\Resource\PostResource;
use MillmanPhotography\Resource\EnquiryResource;
use MillmanPhotography\Controller\BlogController;
use MillmanPhotography\Controller\IndexController;
use MillmanPhotography\Validator\EnquiryValidator;
use MillmanPhotography\Controller\GalleryController;
use MillmanPhotography\Controller\EnquiryController;
use MillmanPhotography\Middleware\CsrfTokenProvider;

$container = $millmanphotography->getContainer();

$container[Plates::class] = function (Container $container) {
    $view = new Plates($container->get('settings')['plates']);
    $view->loadExtension(new PlatesExtension($container['router'], $container['request']->getUri()));
    return $view;
};

$container[Session::class] = function (Container $container) {
    return new Session();
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

$container[Monolog::class] = function (Container $container) {
    $settings = $container->get('settings')['logger'];
    return new Monolog($settings['name'], $settings['settings']);
};

$container[IndexController::class] = function (Container $container) {
    $view = $container->get(Plates::class);
    $galleryController = $container->get(GalleryController::class);
    $blogController = $container->get(BlogController::class);
    return new IndexController($view, $galleryController, $blogController);
};

$container[GalleryController::class] = function (Container $container) {
    $view = $container->get(Plates::class);
    $logger = $container->get(Monolog::class);
    return new GalleryController($view, $logger);
};

$container[BlogController::class] = function (Container $container) {
    $view = $container->get(Plates::class);
    $logger = $container->get(Monolog::class);
    return new BlogController($view, $logger);
};

$container[UserResource::class] = function (Container $container) {
    $entityManager = $container->get(EntityManager::class);
    return new UserResource($entityManager);
};

$container[PostResource::class] = function (Container $container) {
    $entityManager = $container->get(EntityManager::class);
    return new PostResource($entityManager);
};

$container[EnquiryController::class] = function (Container $container) {
    $validator = $container->get(EnquiryValidator::class);
    $resource = $container->get(EnquiryResource::class);
    $logger = $container->get(Monolog::class);
    return new EnquiryController($validator, $resource, $logger);
};

$container[EnquiryValidator::class] = function (Container $container) {
    return new EnquiryValidator();
};

$container[EnquiryResource::class] = function (Container $container) {
    $entityManager = $container->get(EntityManager::class);
    return new EnquiryResource($entityManager);
};

$container[Csrf::class] = function (Container $container) {
    $csrf = new Csrf();
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

if (!$container->get('settings')['displayErrorDetails']) {
    $container['errorHandler'] = function (Container $container) {
        return function (Request $request, Response $response, Exception $exception) use ($container) {
            $logger = $container->get(Monolog::class);
            $message = $exception->getMessage();
            $file = $exception->getFile();
            $line = $exception->getLine();
            $logger->log(100, $message . ' in ' . $file . ' on line ' . $line);
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
        return function (Request $request, Response $response) use ($container) {
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
}
