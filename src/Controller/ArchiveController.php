<?php declare(strict_types = 1);

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Section;
use MillmanPhotography\Resource\PostResource;
use MillmanPhotography\Resource\UserResource;

class ArchiveController
{
    /** @var Plates $view */
    private $view;

    /** @var PostResource $postResource */
    private $postResource;

    /**
     * @param Plates $view
     * @param PostResource $postResource
     */
    public function __construct(
        Plates $view,
        PostResource $postResource
    ) {
        $this->view = $view;
        $this->postResource = $postResource;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response) :Response
    {
        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'archive',
            [
                'sections' => Section::BLOG,
                'posts' => $this->postResource->getArchive(),
            ]
        );
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function archive(Request $request, Response $response) :Response
    {
        $post = $request->getAttribute('post');

        $this->postResource->archive($post);

        return $response->withStatus(204)->withHeader('Location', '/blog/archive');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function restore(Request $request, Response $response) :Response
    {
        $post = $request->getAttribute('post');

        $this->postResource->restore($post);

        return $response->withStatus(204)->withHeader('Location', '/blog');
    }
}
