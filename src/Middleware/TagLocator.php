<?php declare(strict_types = 1);

namespace MillmanPhotography\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Resource\TagResource;

class TagLocator
{
    /**
     * @var TagResource
     */
    private $resource;

    /**
     * @param TagResource $resource
     */
    public function __construct(TagResource $resource)
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
        $tag = $this->resource->getBySlug($slug);

        if (!$tag) {
            return $response->withStatus(404)->withHeader('Location', '/blog/tags/');
        }

        return $next($request->withAttribute('tag', $tag), $response);
    }
}
