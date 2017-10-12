<?php declare(strict_types = 1);

namespace MillmanPhotography\Middleware;

use MillmanPhotography\Resource\GalleryResource;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GalleryLocator
{
    /**
     * @var GalleryResource
     */
    private $resource;

    /**
     * @param GalleryResource $resource
     */
    public function __construct(GalleryResource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next) :Response
    {
        $route = $request->getAttribute('route');
        $slug = $route->getArgument('slug');
        $gallery = $this->resource->getBySlug($slug);

        if (!$gallery) {
            return $response->withStatus(404)->withHeader('Location', '/gallery');
        }

        return $next($request->withAttribute('gallery', $gallery), $response);
    }
}
