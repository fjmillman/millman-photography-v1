<?php

use Slim\Csrf\Guard as Csrf;

use MillmanPhotography\Controller\BlogController;
use MillmanPhotography\Controller\IndexController;
use MillmanPhotography\Middleware\CsrfTokenHeader;
use MillmanPhotography\Middleware\CsrfTokenProvider;
use MillmanPhotography\Controller\GalleryController;
use MillmanPhotography\Controller\EnquiryController;

$millmanphotography->get('/[index]', IndexController::class)->setName('index')->add(CsrfTokenProvider::class)->add(Csrf::class);

$millmanphotography->get('/blog', BlogController::class)->setName('blog');

$millmanphotography->get('/gallery', GalleryController::class)->setName('gallery');

$millmanphotography->post('/enquiry', EnquiryController::class)->setName('enquiry')->add(CsrfTokenHeader::class);
