<?php declare(strict_types = 1);

namespace MillmanPhotography\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Resource\ImageResource;

class ImageLocator
{
    /**
     * @var ImageResource
     */
    private $resource;

    /**
     * @param ImageResource $resource
     */
    public function __construct(ImageResource $resource)
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
        $filename = $route->getArgument('filename');
        $image = $this->resource->getByFilename($filename);

        if (!$image) {
            return $response->withStatus(404)->withHeader('Location', '/image');
        }

        return $next($request->withAttribute('image', $image), $response);
    }
}
