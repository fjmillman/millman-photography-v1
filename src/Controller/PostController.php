<?php

namespace MillmanPhotography\Controller;

use RKA\Session;
use Projek\Slim\Plates;
use League\CommonMark\CommonMarkConverter;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Entity\Post;
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

    /**
     * @param Plates $view
     * @param Session $session
     * @param UserResource $userResource
     * @param PostResource $postResource
     * @param CommonMarkConverter $markdown
     * @param PostValidator $validator
     */
    public function __construct(
        Plates $view,
        Session $session,
        UserResource $userResource,
        PostResource $postResource,
        CommonMarkConverter $markdown,
        PostValidator $validator
    ) {
        $this->view = $view;
        $this->session = $session;
        $this->userResource = $userResource;
        $this->postResource = $postResource;
        $this->markdown = $markdown;
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param string $slug
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $slug)
    {
        $post = $request->getAttribute('post');

        $parsedBody = $this->markdown->convertToHtml($post->getBody());
        $post->setBody($parsedBody);

        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'post',
            [
                'post' => $post,
            ]
        );
    }

    public function create(Request $request, Response $response)
    {
        $this->view->setResponse($response->withStatus(200));
        return $this->view->render('editor');
    }

    public function store(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $post = new Post();

        $post->setTitle($data['title']);
        $post->setBody($data['body']);

        if (!$this->validator->isValid($data)) {
            $this->view->setResponse($response->withStatus(400));
            return $this->view->render('editor', [
                'post' => $post,
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $post->setUser($request->getAttribute('user'));

        if (in_array($post->getSlug(), $this->reservedSlugs, true) ||
            $this->entityManager->getRepository(Post::class)->findOneBy(['slug' => $post->getSlug()])
        ) {
            $post->regenerateSlug();
        }
        $tags = $this->tagRepository->getAll(
            $newPost['tags'] ?? [],
            $newPost['new_tags'] ?? []
        );
        array_walk($tags, [$post, 'addTag']);
        $this->entityManager->persist($post);
        $this->entityManager->flush();
        return $response->withStatus(302)->withHeader('Location', '/post/' . $post->getSlug());
    }

    public function edit(Request $request, Response $response)
    {
        $post = $request->getAttribute('post');

        $this->view->setResponse($response->withStatus(200));
        return $this->view->render('editor',
            [
                'post' => $post,
            ]
        );
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param string $slug
     * @return Response
     */
    public function update(Request $request, Response $response, $slug)
    {
        $post = $request->getAttribute('post');

        $this->view->setResponse($response->withStatus(200));
        return $this->view->render('editor',
            [
                'post' => $post,
            ]
        );
    }
}
