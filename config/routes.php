<?php

use MillmanPhotography\IndexController;
use MillmanPhotography\GalleryController;
use MillmanPhotography\BlogController;

$millmanphotography->get('/[index]', IndexController::class);

$millmanphotography->get('/gallery', GalleryController::class);

$millmanphotography->get('/blog', BlogController::class);
