<?php

namespace MillmanPhotography\Middleware;

use MillmanPhotography\Resource\PostResource;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PostLocator
{
    /**
     * @var PostResource
     */
    private $resource;

    /**
     * @param PostResource $resource
     */
    public function __construct(PostResource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $route = $request->getAttribute('route');
        $slug = $route->getArgument('slug');
        $post = $this->resource->getBySlug($slug);

        if ($post) {
            return $next($request->withAttribute('post', $post), $response);
        }

        return $response->withStatus(404)->withHeader('Location', '/');
    }
}