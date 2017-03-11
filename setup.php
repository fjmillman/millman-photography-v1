<?php

require_once($root . 'bootstrap.php');

if (isset($page)) {
    $$page = new Build($page);
    $$page->render();
}

if (isset($name) && isset($extension)) {
    $serve = new Serve($name, $extension);
    $serve->processImage();
}
