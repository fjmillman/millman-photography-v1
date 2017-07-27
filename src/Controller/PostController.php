<?php

namespace MillmanPhotography\Controller;

use RKA\Session;
use Projek\Slim\Plates;
use Projek\Slim\Monolog;
use Stringy\Stringy as S;
use League\CommonMark\CommonMarkConverter;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Section;
use MillmanPhotography\Resource\PostResource;
use MillmanPhotography\Resource\UserResource;
use MillmanPhotography\Validator\PostValidator;

class PostController
{
    /** @var Plates $view */
    private $view;

    /** @var Session $session */
    private $session;

    /** @var UserResource $userResource */
    private $userResource;

    /** @var PostResource $postResource */
    private $postResource;

    /** @var CommonMarkConverter $markdown */
    private $markdown;

    /** @var PostValidator $validator */
    private $validator;

    /** @var Monolog $logger */
    private $logger;

    /**
     * @param Plates $view
     * @param Session $session
     * @param UserResource $userResource
     * @param PostResource $postResource
     * @param CommonMarkConverter $markdown
     * @param PostValidator $validator
     * @param Monolog $logger
     */
    public function __construct(
        Plates $view,
        Session $session,
        UserResource $userResource,
        PostResource $postResource,
        CommonMarkConverter $markdown,
        PostValidator $validator,
        Monolog $logger
    ) {
        $this->view = $view;
        $this->session = $session;
        $this->userResource = $userResource;
        $this->postResource = $postResource;
        $this->markdown = $markdown;
        $this->validator = $validator;
        $this->logger = $logger;
    }

    /**
     * Get an existing post.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
    {
        $post = $request->getAttribute('post');

        $parsedBody = $this->markdown->convertToHtml($post->getBody());
        $parsedBody = S::create($parsedBody)
            ->replace('<img', '<img class="img-fluid"');
        $post->setBody($parsedBody);

        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'post',
            [
                'post' => $post,
                'sections' => Section::BLOG,
                'previous' => $this->postResource->getPrevious($post->getDateCreated()),
                'next' => $this->postResource->getNext($post->getDateCreated()),
            ]
        );
    }

    /**
     * Create a new post.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response)
    {
        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'editor',
            [
                'sections' => Section::BLOG,
            ]
        );
    }

    /**
     * Store a new post.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function store(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        if (!$this->validator->isValid($data)) {
            return $response->withStatus(400);
        }

        $user = $request->getAttribute('user');
        $slug = $this->postResource->create($data, $user);

        return $response->withStatus(204)->withHeader('Location', '/blog/post/' . $slug);
    }

    /**
     * Edit an existing post.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function edit(Request $request, Response $response)
    {
        $post = $request->getAttribute('post');

        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'editor',
            [
                'sections' => Section::BLOG,
                'post' => $post
            ]
        );
    }

    /**
     * Update an existing post.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function update(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        if (!$this->validator->isValid($data)) {
            return $response->withStatus(400);
        }

        $post = $request->getAttribute('post');
        $slug = $this->postResource->update($post, $data);

        return $response->withStatus(204)->withHeader('Location', '/blog/post/' . $slug);
    }

    /**
     * Delete an existing post.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function delete(Request $request, Response $response)
    {
        $post = $request->getAttribute('post');
        $this->postResource->delete($post);

        return $response->withStatus(204)->withHeader('Location', '/blog');
    }
}
