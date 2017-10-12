<?php declare(strict_types = 1);

namespace MillmanPhotography\Extension;

use League\Plates\Engine;
use League\Glide\Urls\UrlBuilder;
use League\Plates\Extension\ExtensionInterface;

class UrlBuilderExtension implements ExtensionInterface
{
    /** @var UrlBuilder $urlBuilder */
    private $urlBuilder;

    /**
     * @param UrlBuilder $urlBuilder
     */
    public function __construct(UrlBuilder $urlBuilder)
    {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @param Engine $engine
     * @return void
     */
    public function register(Engine $engine) :void
    {
        $engine->registerFunction('getUrl', [$this, 'getUrl']);
    }

    /**
     * @param string $filename
     * @param array $size
     * @return string
     */
    public function getUrl(string $filename, array $size) : string
    {
        return $this->urlBuilder->getUrl($filename . '.jpg', $size);
    }
}
