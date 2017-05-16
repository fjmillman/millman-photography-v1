<?php

use MillmanPhotography\Controller\IndexController;
use MillmanPhotography\Controller\GalleryController;
use MillmanPhotography\Controller\BlogController;

$millmanphotography->get('/[index]', IndexController::class);

$millmanphotography->get('/gallery', GalleryController::class);

$millmanphotography->get('/blog', BlogController::class);
