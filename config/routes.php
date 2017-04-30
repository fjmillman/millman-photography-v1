<?php

use \MillmanPhotography\Page;
use \MillmanPhotography\Config;
use \MillmanPhotography\ImageConfig;

$millmanphotography->get('/[index]', function ($request, $response) {
    return $this->view->render($response->withStatus(200), 'index.html',
        [
            'title' => Page::MILLMAN_PHOTOGRAPHY,
            'image' => [
                Config::IMAGE_ROOT . ImageConfig::NORTHUMBERLAND . ImageConfig::EXT_JPEG,
                Config::IMAGE_ROOT . ImageConfig::ROSEBERRY_TOPPING . ImageConfig::EXT_JPEG,
                Config::IMAGE_ROOT . ImageConfig::BATH . ImageConfig::EXT_JPEG,
                Config::IMAGE_ROOT . ImageConfig::ASHNESS_JETTY . ImageConfig::EXT_JPEG,
                Config::IMAGE_ROOT . ImageConfig::DURDLE_DOOR . ImageConfig::EXT_JPEG,
                Config::IMAGE_ROOT . ImageConfig::KERNOW . ImageConfig::EXT_JPEG,
                Config::IMAGE_ROOT . ImageConfig::SWALEDALE . ImageConfig::EXT_JPEG,
            ]
        ]
    );
});

$millmanphotography->get('/about', function ($request, $response) {
    return $this->view->render($response->withStatus(200), 'aboutme.html',
        [
            'title' => Page::ABOUT_ME,
            'baseUrl' => Config::BASE_URL,
        ]
    );
});

$millmanphotography->get('/gallery', function ($request, $response) {

});

$millmanphotography->get('/blog', function ($request, $response) {

});

$millmanphotography->get('/prints', function ($request, $response) {

});

$millmanphotography->get('/contact', function ($request, $response) {

});
