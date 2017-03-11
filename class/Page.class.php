<?php

class Page
{
    const HOME = 'Home';
    const ABOUT_ME = 'About Me';
    const GALLERY = 'Gallery';
    const BLOG_POSTS = 'Blog Posts';
    const PRINTS = 'Prints';
    const CONTACT_ME = 'Contact Me';
    const STATUS_404 = 'Status 404';

    const PARENT = [
        self::HOME,
        self::ABOUT_ME,
        self::GALLERY,
        self::BLOG_POSTS,
        self::PRINTS,
        self::CONTACT_ME,
        self::STATUS_404,
    ];
}