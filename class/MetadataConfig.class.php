<?php

class MetadataConfig
{
    const CHARSET = 'utf-8';
    const DESCRIPTION = 'Millman Photography';
    const AUTHOR = 'Freddie John Millman';
    const KEYWORDS = 'freddie fred john millman photography gallery';

    const METADATA = [
        'charset' => self::CHARSET,
        'name' => [
            'description' => self::DESCRIPTION,
            'author' => self::AUTHOR,
            'keywords' => self::KEYWORDS,
        ],
    ];
}
