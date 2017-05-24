<?php

$millmanphotography->add(\MillmanPhotography\Middleware\CsrfTokenProvider::class);
$millmanphotography->add(\Slim\Csrf\Guard::class);
