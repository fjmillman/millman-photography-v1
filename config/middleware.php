<?php

use MillmanPhotography\Middleware\CsrfTokenProvider;
use Slim\Csrf\Guard as Csrf;

$millmanphotography->add(CsrfTokenProvider::class);
$millmanphotography->add(Csrf::class);
