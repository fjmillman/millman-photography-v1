<?php

use MillmanPhotography\Controller\IndexController;
use MillmanPhotography\Controller\GalleryController;
use MillmanPhotography\Controller\BlogController;
use MillmanPhotography\Controller\ContactController;

$millmanphotography->get('/[index]', IndexController::class);

$millmanphotography->get('/blog', BlogController::class);

$millmanphotography->get('/gallery', GalleryController::class);

$millmanphotography->post('/contact', ContactController::class);
