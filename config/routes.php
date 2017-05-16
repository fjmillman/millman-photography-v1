<?php

use MillmanPhotography\IndexController;
use MillmanPhotography\BlogController;
use MillmanPhotography\GalleryController;
use MillmanPhotography\ContactController;

$millmanphotography->get('/[index]', IndexController::class);

$millmanphotography->get('/blog', BlogController::class);

$millmanphotography->get('/gallery', GalleryController::class);

$millmanphotography->post('/contact', ContactController::class);
