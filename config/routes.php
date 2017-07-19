<?php

use Slim\Csrf\Guard as Csrf;

use MillmanPhotography\Middleware\PostLocator;
use MillmanPhotography\Controller\BlogController;
use MillmanPhotography\Controller\PostController;
use MillmanPhotography\Controller\AdminController;
use MillmanPhotography\Controller\IndexController;
use MillmanPhotography\Middleware\CsrfTokenHeader;
use MillmanPhotography\Controller\LoginController;
use MillmanPhotography\Controller\UploadController;
use MillmanPhotography\Controller\GalleryController;
use MillmanPhotography\Controller\EnquiryController;
use MillmanPhotography\Middleware\CsrfTokenProvider;
use MillmanPhotography\Controller\RegistrationController;
use MillmanPhotography\Middleware\AuthorisationMiddleware;

$millmanphotography->get('/', IndexController::class)->setName('index')->add(CsrfTokenProvider::class)->add(Csrf::class);

$millmanphotography->get('/blog', BlogController::class)->setName('blog');

$millmanphotography->get('/blog/post/{slug:[a-zA-Z\d\s-_\-]+}', PostController::class)->add(PostLocator::class);

$millmanphotography->get('/gallery', GalleryController::class)->setName('gallery');

$millmanphotography->post('/enquiry', EnquiryController::class)->setName('enquiry')->add(CsrfTokenHeader::class);

$millmanphotography->get('/admin', AdminController::class)->setName('admin')->add(AuthorisationMiddleware::class)->add(CsrfTokenProvider::class)->add(Csrf::class);

$millmanphotography->get('/login', LoginController::class)->setName('login')->add(CsrfTokenProvider::class)->add(Csrf::class);
$millmanphotography->post('/login', LoginController::class . ':login');
$millmanphotography->get('/logout', LoginController::class . ':logout')->setName('logout')->add(AuthorisationMiddleware::class);

if (getenv('ENABLE_REGISTRATION')) {
    $millmanphotography->get('/register', RegistrationController::class)->setName('register')->add(CsrfTokenProvider::class)->add(Csrf::class);
    $millmanphotography->post('/register', RegistrationController::class . ':register');
}

$millmanphotography->post('/upload', UploadController::class)->setName('upload')->add(AuthorisationMiddleware::class);
