<?php

$root = '/home/fjmillman/millmanphotography/';

$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

switch ($request_uri[0]) {
    case '/':
        $page = 'index';
        break;
    case '/aboutme':
        $page = 'aboutme';
        break;
    case '/gallery':
        $page = 'gallery';
        break;
    case '/blogposts':
        $page = 'blogposts';
        break;
    case '/prints':
        $page = 'prints';
        break;
    case '/contactme':
        $page = 'contactme';
        break;
    default:
        header('HTTP/1.0 404 Not Found');
        $page = 'status404';
        break;
}

require_once($root . 'setup.php');