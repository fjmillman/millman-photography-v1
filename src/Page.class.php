<?php

namespace MillmanPhotography;

class Page
{
    /** @var string ABOUT */
    const ABOUT = 'about';

    /** @var string GALLERY */
    const GALLERY = 'gallery';

    /** @var string SERVICES */
    const SERVICES = 'services';

    /** @var string BLOG */
    const BLOG = 'blog';

    /** @var string CONTACT */
    const CONTACT = 'contact';

    /**
     * @return array
     */
    public static function getPages()
    {
        return [
            self::BLOG,
            self::ABOUT,
            self::GALLERY,
            self::SERVICES,
            self::CONTACT,
        ];
    }
}
