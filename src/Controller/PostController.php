<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Projek\Slim\Monolog;
use Stringy\Stringy as S;
use Arrayzy\ArrayImitator as A;
use League\CommonMark\CommonMarkConverter;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Section;
use MillmanPhotography\Entity\Tag;
use MillmanPhotography\Entity\PostTag;
use MillmanPhotography\Resource\TagResource;
use MillmanPhotography\Resource\PostResource;
use MillmanPhotography\Validator\PostValidator;

class PostController
{
    /** @var Plates $view */
    private $view;

    /** @var PostResource $postResource */
    private $postResource;

    /** @var TagResource $tagResource */
    private $tagResource;

    /** @var CommonMarkConverter $markdown */
    private $markdown;

    /** @var PostValidator $validator */
    private $validator;

    /** @var Monolog $logger */
    private $logger;

    /**
     * @param Plates $view
     * @param PostResource $postResource
     * @param TagResource $tagResource
     * @param CommonMarkConverter $markdown
     * @param PostValidator $validator
     * @param Monolog $logger
     */
    public function __construct(
        Plates $view,
        PostResource $postResource,
        TagResource $tagResource,
        CommonMarkConverter $markdown,
        PostValidator $validator,
        Monolog $logger
    ) {
        $this->view = $view;
        $this->postResource = $postResource;
        $this->tagResource = $tagResource;
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
                'sections' => Section::BLOG,
                'post' => $post,
                'previous' => $this->postResource->getPrevious($post),
                'next' => $this->postResource->getNext($post),
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
        $tags = $this->tagResource->get();

        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'editor',
            [
                'sections' => Section::BLOG,
                'tagData' => json_encode(['tags' => $this->processTagData($tags)]),
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

        $tags = $this->tagResource->process(
            array_key_exists('new_tags', $data) ? (is_array($data['new_tags']) ? $data['new_tags'] : []) : []
        );

        $user = $request->getAttribute('user');
        $slug = $this->postResource->create($data, $tags, $user);

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

        $tags = $this->tagResource->get();

        $selectedTags = array_map(function (PostTag $postTag) {
            return $postTag->getTag();
        }, $post->getPostTag());

        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'editor',
            [
                'sections' => Section::BLOG,
                'post' => $post,
                'tagData' => json_encode([
                    'tags' => $this->processTagData($tags),
                    'selected_tags' => $this->processTagData($selectedTags),
                ]),
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

        $tags = $this->tagResource->process(
            array_key_exists('new_tags', $data) ? (is_array($data['new_tags']) ? $data['new_tags'] : []) : [],
            array_key_exists('tags', $data) ? (is_array($data['tags']) ? $data['tags'] : []) : []
        );

        $post = $request->getAttribute('post');
        $slug = $this->postResource->update($post, $data, $tags);

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

        foreach($post->getPostTag() as $postTag) {
            $post->removePostTag($postTag);
        }

        $this->postResource->delete($post);

        return $response->withStatus(204)->withHeader('Location', '/blog');
    }

    /**
     * Process the tags for tags data
     *
     * @param array $tags
     * @return array
     */
    private function processTagData(array $tags)
    {
        return A::create($tags)->customSort(function (Tag $a, Tag $b) {
            return count($a->getPostTag()) >= count($b->getPostTag());
        })->map(function (Tag $tag) {
            return [
                'id' => $tag->getId(),
                'name' => $tag->getName(),
            ];
        })->toArray();
    }
}
