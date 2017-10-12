<?php declare(strict_types = 1);

use Slim\Csrf\Guard as Csrf;
use MillmanPhotography\Middleware\TagLocator;
use MillmanPhotography\Middleware\PostLocator;
use MillmanPhotography\Middleware\UserProvider;
use MillmanPhotography\Middleware\ImageLocator;
use MillmanPhotography\Controller\TagController;
use MillmanPhotography\Controller\BlogController;
use MillmanPhotography\Controller\PostController;
use MillmanPhotography\Middleware\GalleryLocator;
use MillmanPhotography\Controller\IndexController;
use MillmanPhotography\Middleware\CsrfTokenHeader;
use MillmanPhotography\Controller\LoginController;
use MillmanPhotography\Controller\ImageController;
use MillmanPhotography\Controller\ArchiveController;
use MillmanPhotography\Controller\GalleryController;
use MillmanPhotography\Controller\EnquiryController;
use MillmanPhotography\Middleware\CsrfTokenProvider;
use MillmanPhotography\Controller\RegistrationController;
use MillmanPhotography\Middleware\AuthorisationMiddleware;

$millmanphotography->get('/', IndexController::class)->add(CsrfTokenProvider::class)->add(Csrf::class);;

$millmanphotography->group('/image', function () {
    $this->get('', ImageController::class);

    $this->get('/new', ImageController::class . ':create')->add(CsrfTokenProvider::class)->add(Csrf::class);
    $this->post('/new', ImageController::class . ':store');

    $this->group('', function () {
        $this->get('/edit/{filename:[a-zA-Z\d\s-_\-]+}', ImageController::class . ':edit')->add(CsrfTokenProvider::class)->add(Csrf::class);
        $this->post('/edit/{filename:[a-zA-Z\d\s-_\-]+}', ImageController::class . ':update');
        $this->get('/delete/{filename:[a-zA-Z\d\s-_\-]+}', ImageController::class . ':delete');
        $this->get('/{filename:[a-zA-Z\d\s-_\-]+}', ImageController::class . ':show');
    })->add(ImageLocator::class);
})->add(AuthorisationMiddleware::class);

$millmanphotography->group('/blog', function () {
    $this->get('', BlogController::class);
    $this->get('/tags', BlogController::class . ':tags');
    $this->get('/archive', BlogController::class . ':archive');

    $this->group('/post', function () {
        $this->get('/new', PostController::class . ':create')->add(CsrfTokenProvider::class)->add(Csrf::class);
        $this->post('/new', PostController::class . ':store')->add(UserProvider::class);

        $this->group('', function () {
            $this->get('/edit/{slug:[a-zA-Z\d\s-_\-]+}', PostController::class . ':edit')->add(CsrfTokenProvider::class)->add(Csrf::class);
            $this->post('/edit/{slug:[a-zA-Z\d\s-_\-]+}', PostController::class . ':update');
            $this->get('/delete/{slug:[a-zA-Z\d\s-_\-]+}', PostController::class . ':delete');
            $this->get('/archive/{slug:[a-zA-Z\d\s-_\-]+}', ArchiveController::class . ':archive');
            $this->get('/restore/{slug:[a-zA-Z\d\s-_\-]+}', ArchiveController::class . ':restore');
        })->add(PostLocator::class);
    })->add(AuthorisationMiddleware::class);

    $this->group('', function () {
        $this->get('/post/{slug:[a-zA-Z\d\s-_\-]+}', PostController::class);
        $this->get('/archive/{slug:[a-zA-Z\d\s-_\-]+}', ArchiveController::class);
    })->add(PostLocator::class);

    $this->get('/tag/{slug:[a-zA-Z\d\s-_\-]+}', TagController::class)->add(TagLocator::class);
});

$millmanphotography->group('/gallery', function () {
    $this->get('', GalleryController::class);

    $this->group('', function () {
        $this->get('/new', GalleryController::class . ':create')->add(CsrfTokenProvider::class)->add(Csrf::class);
        $this->post('/new', GalleryController::class . ':store');

        $this->group('', function () {
            $this->get('/edit/{slug:[a-zA-Z\d\s-_\-]+}', GalleryController::class . ':edit')->add(CsrfTokenProvider::class)->add(Csrf::class);
            $this->post('/edit/{slug:[a-zA-Z\d\s-_\-]+}', GalleryController::class . ':update');
            $this->get('/delete/{slug:[a-zA-Z\d\s-_\-]+}', GalleryController::class . ':delete');
        })->add(GalleryLocator::class);
    })->add(AuthorisationMiddleware::class);

    $this->get('/{slug:[a-zA-Z\d\s-_\-]+}', GalleryController::class . ':show')->add(GalleryLocator::class);
});

$millmanphotography->post('/enquiry', EnquiryController::class)->add(CsrfTokenHeader::class);

$millmanphotography->get('/login', LoginController::class)->add(CsrfTokenProvider::class)->add(Csrf::class);
$millmanphotography->post('/login', LoginController::class . ':login');
$millmanphotography->get('/logout', LoginController::class . ':logout')->add(AuthorisationMiddleware::class);

if (getenv('ENABLE_REGISTRATION')) {
    $millmanphotography->get('/register', RegistrationController::class)->add(CsrfTokenProvider::class)->add(Csrf::class);
    $millmanphotography->post('/register', RegistrationController::class . ':register');
}
