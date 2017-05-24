<?php

use MillmanPhotography\Controller\BlogController;
use MillmanPhotography\Controller\IndexController;
use MillmanPhotography\Controller\GalleryController;
use MillmanPhotography\Controller\EnquiryController;

$millmanphotography->get('/[index]', IndexController::class)->setName('index');

$millmanphotography->get('/blog', BlogController::class)->setName('blog');

$millmanphotography->get('/gallery', GalleryController::class)->setName('gallery');

$millmanphotography->post('/contact', EnquiryController::class)->setName('contact');
