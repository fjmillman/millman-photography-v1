<?php

use Slim\Csrf\Guard as Csrf;

use MillmanPhotography\Middleware\CsrfTokenView;
use MillmanPhotography\Controller\BlogController;
use MillmanPhotography\Middleware\CsrfTokenHeader;
use MillmanPhotography\Controller\IndexController;
use MillmanPhotography\Controller\GalleryController;
use MillmanPhotography\Controller\ContactController;

$millmanphotography->get('/[index]', IndexController::class)->setName('index')
    ->add(CsrfTokenView::class)->add(Csrf::class);

$millmanphotography->get('/blog', BlogController::class)->setName('blog');

$millmanphotography->get('/gallery', GalleryController::class)->setName('gallery');

$millmanphotography->post('/contact', ContactController::class)->setName('contact')
    ->add(CsrfTokenHeader::class)->add(Csrf::class);
