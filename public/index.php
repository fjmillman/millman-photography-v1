<?php

$root = '/home/fjmillman/millmanphotography/';

$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

switch ($request_uri[0]) {
    case '/':
        $page = 'Home';
        break;
    case '/aboutme':
        $page = 'About Me';
        break;
    case '/gallery':
        $page = 'Gallery';
        break;
    case '/blogposts':
        $page = 'Blog Posts';
        break;
    case '/prints':
        $page = 'Prints';
        break;
    case '/contactme':
        $page = 'Contact Me';
        break;
    default:
        header('HTTP/1.0 404 Not Found');
        break;
}

require_once($root . 'setup.php');