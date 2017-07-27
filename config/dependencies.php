<?php

use RKA\Session;
use Slim\Container;
use Pelago\Emogrifier;
use Projek\Slim\Plates;
use Projek\Slim\Monolog;
use Slim\Csrf\Guard as Csrf;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Swift_Mailer as SwiftMailer;
use Projek\Slim\PlatesExtension;
use League\CommonMark\CommonMarkConverter;
use Swift_SmtpTransport as SwiftSmtpTransport;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Mailer;
use MillmanPhotography\Resource\UserResource;
use MillmanPhotography\Resource\PostResource;
use MillmanPhotography\Resource\ImageResource;
use MillmanPhotography\Validator\PostValidator;
use MillmanPhotography\Middleware\PostLocator;
use MillmanPhotography\Middleware\UserProvider;
use MillmanPhotography\Resource\GalleryResource;
use MillmanPhotography\Resource\EnquiryResource;
use MillmanPhotography\Controller\BlogController;
use MillmanPhotography\Controller\PostController;
use MillmanPhotography\Controller\LoginController;
use MillmanPhotography\Validator\EnquiryValidator;
use MillmanPhotography\Controller\AdminController;
use MillmanPhotography\Middleware\CsrfTokenHeader;
use MillmanPhotography\Controller\IndexController;
use MillmanPhotography\Controller\GalleryController;
use MillmanPhotography\Controller\EnquiryController;
use MillmanPhotography\Controller\ArchiveController;
use MillmanPhotography\Middleware\CsrfTokenProvider;
use MillmanPhotography\Validator\RegistrationValidator;
use MillmanPhotography\Controller\RegistrationController;
use MillmanPhotography\Middleware\AuthorisationMiddleware;

$container = $millmanphotography->getContainer();

$container[Plates::class] = function (Container $container) {
    $view = new Plates($container->get('settings')['plates']);
    $view->loadExtension(new PlatesExtension($container['router'], $container['request']->getUri()));
    return $view;
};

$container['Plates::body'] = function (Container $container) {
    $view = new Plates($container->get('settings')['plates']);
    $view->loadExtension(new PlatesExtension($container['router'], $container['request']->getUri()));
    return $view;
};

$container[Session::class] = function (Container $container) {
    return new Session();
};

$container[UserProvider::class] = function (Container $container) {
    $view = $container->get(Plates::class);
    $session = $container->get(Session::class);
    $resource = $container->get(UserResource::class);
    return new UserProvider($view, $session, $resource);
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
    $galleryResource = $container->get(GalleryResource::class);
    $postResource = $container->get(PostResource::class);
    return new IndexController($view, $galleryResource, $postResource);
};

$container[ImageResource::class] = function (Container $container) {
    $entityManager = $container->get(EntityManager::class);
    return new ImageResource($entityManager);
};

$container[GalleryController::class] = function (Container $container) {
    $view = $container->get(Plates::class);
    $galleryResource = $container->get(GalleryResource::class);
    return new GalleryController($view, $galleryResource);
};

$container[GalleryResource::class] = function (Container $container) {
    $entityManager = $container->get(EntityManager::class);
    return new GalleryResource($entityManager);
};

$container[BlogController::class] = function (Container $container) {
    $view = $container->get(Plates::class);
    $postResource = $container->get(PostResource::class);
    return new BlogController($view, $postResource);
};

$container[PostLocator::class] = function (Container $container) {
    $resource = $container->get(PostResource::class);
    return new PostLocator($resource);
};

$container[PostController::class] = function (Container $container) {
    $view = $container->get(Plates::class);
    $postResource = $container->get(PostResource::class);
    $markdown = $container->get(CommonMarkConverter::class);
    $validator = $container->get(PostValidator::class);
    $logger = $container->get(Monolog::class);
    return new PostController($view, $postResource, $markdown, $validator, $logger);
};

$container[CommonMarkConverter::class] = function (Container $container) {
    $settings = $container->get('settings')['markdown'];
    return new CommonMarkConverter($settings);
};

$container[PostResource::class] = function (Container $container) {
    $entityManager = $container->get(EntityManager::class);
    return new PostResource($entityManager);
};

$container[PostValidator::class] = function (Container $container) {
    return new PostValidator();
};

$container[ArchiveController::class] = function (Container $container) {
    $view = $container->get(Plates::class);
    $postResource = $container->get(PostResource::class);
    return new ArchiveController($view, $postResource);
};

$container[EnquiryController::class] = function (Container $container) {
    $validator = $container->get(EnquiryValidator::class);
    $resource = $container->get(EnquiryResource::class);
    $mailer = $container->get(Mailer::class);
    $logger = $container->get(Monolog::class);
    return new EnquiryController($validator, $resource, $mailer, $logger);
};

$container[EnquiryValidator::class] = function (Container $container) {
    return new EnquiryValidator();
};

$container[EnquiryResource::class] = function (Container $container) {
    $entityManager = $container->get(EntityManager::class);
    return new EnquiryResource($entityManager);
};

$container[AdminController::class] = function (Container $container) {
    $view = $container->get(Plates::class);
    return new AdminController($view);
};

$container[UserResource::class] = function (Container $container) {
    $entityManager = $container->get(EntityManager::class);
    return new UserResource($entityManager);
};

$container[AuthorisationMiddleware::class] = function (Container $container) {
    $session = $container->get(Session::class);
    $resource = $container->get(UserResource::class);
    $logger = $container->get(Monolog::class);
    return new AuthorisationMiddleware($session, $resource, $logger);
};

$container[RegistrationController::class] = function (Container $container) {
    $view = $container->get(Plates::class);
    $session = $container->get(Session::class);
    $validator = $container->get(RegistrationValidator::class);
    $resource = $container->get(UserResource::class);
    return new RegistrationController($view, $session, $validator, $resource);
};

$container[RegistrationValidator::class] = function (Container $container) {
    return new RegistrationValidator();
};

$container[LoginController::class] = function (Container $container) {
    $view = $container->get(Plates::class);
    $session = $container->get(Session::class);
    $resource = $container->get(UserResource::class);
    return new LoginController($view, $session, $resource);
};

$container[SwiftSMTPTransport::class] = function (Container $container) {
    $settings = $container->get('settings')['mailer'];
    $transport = new SwiftSMTPTransport($settings['host'], $settings['port'], $settings['security']);
    return $transport
        ->setUsername($settings['username'])
        ->setPassword($settings['password'])
        ->setAuthMode($settings['authentication']);
};

$container[SwiftMailer::class] = function (Container $container) {
    $transport = $container->get(SwiftSMTPTransport::class);
    return new SwiftMailer($transport);
};

$container[Emogrifier::class] = function (Container $container) {
    return new Emogrifier();
};

$container[Mailer::class] = function (Container $container) {
    $view = $container->get(Plates::class);
    $body = $container->get('Plates::body');
    $emogrifier = $container->get(Emogrifier::class);
    $mailer = $container->get(SwiftMailer::class);
    return new Mailer($view, $body, $emogrifier, $mailer);
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

$container[CsrfTokenHeader::class] = function (Container $container) {
    return new CsrfTokenHeader($container->get(Csrf::class));
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
