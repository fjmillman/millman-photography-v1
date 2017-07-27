<?php

namespace MillmanPhotography;

class Section
{
    /** @var string BLOG */
    const BLOG = [
        'Posts' => 'blog',
        'Tags' => 'blog/tags',
        'Archive' => 'blog/archive',
    ];

    /** @var string GALLERY */
    const GALLERY = [
        'Galleries' => 'gallery'
    ];

    /** @var array SECTIONS */
    const SECTIONS = [
        'Blog' => self::BLOG,
        'About' => 'about',
        'Gallery' => self::GALLERY,
        'Services' => 'services',
        'Enquiry' => 'enquiry',
    ];
}
