<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Arrayzy\ArrayImitator as A;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Section;
use MillmanPhotography\Entity\Tag;
use MillmanPhotography\Resource\TagResource;
use MillmanPhotography\Resource\PostResource;

class BlogController
{
    /** @var Plates $view */
    private $view;

    /** @var PostResource $postResource */
    private $postResource;

    /** @var TagResource $tagResource */
    private $tagResource;

    /**
     * @param Plates $view
     * @param PostResource $postResource
     * @param TagResource $tagResource
     */
    public function __construct(
        Plates $view,
        PostResource $postResource,
        TagResource $tagResource
    ) {
        $this->view = $view;
        $this->postResource = $postResource;
        $this->tagResource = $tagResource;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
    {
        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'blog',
            [
                'posts' => $this->postResource->get(),
                'sections' => Section::BLOG,
            ]
        );
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function archive(Request $request, Response $response)
    {
        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'archive',
            [
                'posts' => $this->postResource->getArchive(),
                'sections' => Section::BLOG,
            ]
        );
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function tags(Request $request, Response $response)
    {
        $tags = A::create($this->tagResource->get())->map(function (Tag $tag) {
            return $tag->filterArchivedPostsFromTag();
        })->toArray();

        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'tags',
            [
                'tags' => $tags,
                'sections' => Section::BLOG,
            ]
        );
    }
}
