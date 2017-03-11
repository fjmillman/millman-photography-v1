<?php

$root = '/home/fjmillman/millmanphotography/';

$image = $_GET['image'];

if (isset($image)) {
    if (substr_count($image, '.') == 1) {
        $details = explode('.', $_GET['image']);
        $name = $details[0];
        $extension = $details[1];

        require_once($root . 'setup.php');
    }
}
