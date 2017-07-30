<?php

use Slim\Csrf\Guard as Csrf;
use MillmanPhotography\Middleware\TagLocator;
use MillmanPhotography\Middleware\PostLocator;
use MillmanPhotography\Middleware\UserProvider;
use MillmanPhotography\Controller\TagController;
use MillmanPhotography\Controller\BlogController;
use MillmanPhotography\Controller\PostController;
use MillmanPhotography\Controller\AdminController;
use MillmanPhotography\Controller\IndexController;
use MillmanPhotography\Middleware\CsrfTokenHeader;
use MillmanPhotography\Controller\LoginController;
use MillmanPhotography\Controller\UploadController;
use MillmanPhotography\Controller\ArchiveController;
use MillmanPhotography\Controller\GalleryController;
use MillmanPhotography\Controller\EnquiryController;
use MillmanPhotography\Middleware\CsrfTokenProvider;
use MillmanPhotography\Controller\RegistrationController;
use MillmanPhotography\Middleware\AuthorisationMiddleware;

$millmanphotography->get('/', IndexController::class)->add(CsrfTokenProvider::class)->add(Csrf::class);;

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

$millmanphotography->get('/gallery', GalleryController::class);

$millmanphotography->post('/enquiry', EnquiryController::class)->add(CsrfTokenHeader::class);

$millmanphotography->get('/admin', AdminController::class)->add(AuthorisationMiddleware::class)->add(CsrfTokenProvider::class)->add(Csrf::class);

$millmanphotography->get('/login', LoginController::class)->add(CsrfTokenProvider::class)->add(Csrf::class);
$millmanphotography->post('/login', LoginController::class . ':login');
$millmanphotography->get('/logout', LoginController::class . ':logout')->add(AuthorisationMiddleware::class);

if (getenv('ENABLE_REGISTRATION')) {
    $millmanphotography->get('/register', RegistrationController::class)->add(CsrfTokenProvider::class)->add(Csrf::class);
    $millmanphotography->post('/register', RegistrationController::class . ':register');
}

$millmanphotography->post('/upload', UploadController::class)->add(AuthorisationMiddleware::class);
