<?php

use \MillmanPhotography\IndexController;
use \MillmanPhotography\AboutMeController;
use \MillmanPhotography\ContactMeController;

$millmanphotography->get('/[index]', IndexController::class);

$millmanphotography->get('/aboutme', AboutMeController::class);

$millmanphotography->get('/gallery', function ($request, $response) {

});

$millmanphotography->get('/blogposts', function ($request, $response) {

});

$millmanphotography->get('/prints', function ($request, $response) {

});

$millmanphotography->get('/contactme', ContactMeController::class);
