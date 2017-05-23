<?php

use Slim\Csrf\Guard as Csrf;

use MillmanPhotography\Controller\BlogController;
use MillmanPhotography\Middleware\CsrfTokenHeader;
use MillmanPhotography\Controller\IndexController;
use MillmanPhotography\Controller\GalleryController;
use MillmanPhotography\Controller\ContactController;

$millmanphotography->get('/[index]', IndexController::class)->setName('index');

$millmanphotography->get('/blog', BlogController::class)->setName('blog');

$millmanphotography->get('/gallery', GalleryController::class)->setName('gallery');

$millmanphotography->post('/contact', ContactController::class)->setName('contact');
