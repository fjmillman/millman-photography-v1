<?php

$millmanphotography->add(\MillmanPhotography\Middleware\CsrfTokenView::class);
$millmanphotography->add(\Slim\Csrf\Guard::class);
