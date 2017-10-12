<?php declare(strict_types = 1);

namespace MillmanPhotography;

class Section
{
    const IMAGE = [
        'Images' => 'image',
        'Blog' => self::BLOG,
        'Gallery' => self::GALLERY,
    ];

    /** @var string BLOG */
    const BLOG = [
        'Posts' => 'blog',
        'Tags' => 'blog/tags',
        'Archive' => 'blog/archive',
        'Images' => 'image',
    ];

    /** @var string GALLERY */
    const GALLERY = [
        'Galleries' => 'gallery',
        'Images' => 'image',
    ];

    /** @var array SECTIONS */
    const SECTIONS = [
        'Blog' => self::BLOG,
        'About' => 'about',
        'Gallery' => self::GALLERY,
        'Services' => 'services',
        'Enquiry' => 'enquiry',
        'Images' => 'image',
    ];
}
