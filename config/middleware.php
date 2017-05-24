<?php

use Slim\Csrf\Guard as Csrf;

use MillmanPhotography\Middleware\CsrfTokenProvider;

$millmanphotography->add(CsrfTokenProvider::class);
$millmanphotography->add(Csrf::class);
