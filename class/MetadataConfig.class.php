<?php

class MetadataConfig
{
    const CHARSET = 'utf-8';
    const DESCRIPTION = 'Millman Photography';
    const AUTHOR = 'Freddie John Millman';
    const VIEWPORT = 'width=device-width; initial-scale=1.0';
    const KEYWORDS = 'freddie fred john millman photography gallery';

    const METADATA = [
        'charset' => self::CHARSET,
        'name' => [
            'description' => self::DESCRIPTION,
            'author' => self::AUTHOR,
            'viewport' => self::VIEWPORT,
            'keywords' => self::KEYWORDS,
        ],
    ];
}
