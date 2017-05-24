<?php

namespace MillmanPhotography;

class Section
{
    /** @var string BLOG */
    const BLOG = 'blog';

    /** @var string ABOUT */
    const ABOUT = 'about';

    /** @var string GALLERY */
    const GALLERY = 'gallery';

    /** @var string SERVICES */
    const SERVICES = 'services';

    /** @var string ENQUIRY */
    const ENQUIRY = 'enquiry';

    /** @var array SECTIONS */
    const SECTIONS = [
        self::BLOG,
        self::ABOUT,
        self::GALLERY,
        self::SERVICES,
        self::ENQUIRY,
    ];
}
