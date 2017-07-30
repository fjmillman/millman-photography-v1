<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Section;
use MillmanPhotography\Resource\TagResource;

class TagController
{
    /** @var Plates $view */
    private $view;

    /** @var TagResource $resource */
    private $resource;

    /**
     * @param Plates $view
     * @param TagResource $resource
     */
    public function __construct(Plates $view, TagResource $resource)
    {
        $this->view = $view;
        $this->resource = $resource;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
    {
        $tag = $request->getAttribute('tag');
        $previousTag = $this->resource->getPrevious($tag);
        $nextTag = $this->resource->getNext($tag);

        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'tag',
            [
                'sections' => Section::BLOG,
                'tag' => $tag->filterArchivedPostsFromTag(),
                'previous' => $previousTag ? $previousTag->filterArchivedPostsFromTag() : null,
                'next' => $nextTag ? $nextTag->filterArchivedPostsFromTag() : null,
            ]
        );
    }
}
