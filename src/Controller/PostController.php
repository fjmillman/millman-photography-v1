<?php declare(strict_types = 1);

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Projek\Slim\Monolog;
use Arrayzy\ArrayImitator as A;
use League\Glide\Urls\UrlBuilder;
use League\CommonMark\CommonMarkConverter;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Section;
use MillmanPhotography\Entity\Tag;
use MillmanPhotography\Entity\Post;
use MillmanPhotography\Entity\Image;
use MillmanPhotography\Entity\PostTag;
use MillmanPhotography\Entity\PostImage;
use MillmanPhotography\Resource\TagResource;
use MillmanPhotography\Resource\PostResource;
use MillmanPhotography\Resource\ImageResource;
use MillmanPhotography\Validator\PostValidator;

class PostController
{
    /** @var Plates $view */
    private $view;

    /** @var PostResource $postResource */
    private $postResource;

    /** @var ImageResource $imageResource */
    private $imageResource;

    /** @var UrlBuilder $urlBuilder */
    private $urlBuilder;

    /** @var TagResource $tagResource */
    private $tagResource;

    /** @var CommonMarkConverter $markdown */
    private $markdown;

    /** @var PostValidator $validator */
    private $validator;

    /**
     * @param Plates $view
     * @param PostResource $postResource
     * @param ImageResource $imageResource
     * @param UrlBuilder $urlBuilder
     * @param TagResource $tagResource
     * @param CommonMarkConverter $markdown
     * @param PostValidator $validator
     */
    public function __construct(
        Plates $view,
        PostResource $postResource,
        ImageResource $imageResource,
        UrlBuilder $urlBuilder,
        TagResource $tagResource,
        CommonMarkConverter $markdown,
        PostValidator $validator
    ) {
        $this->view = $view;
        $this->postResource = $postResource;
        $this->imageResource = $imageResource;
        $this->urlBuilder = $urlBuilder;
        $this->tagResource = $tagResource;
        $this->markdown = $markdown;
        $this->validator = $validator;
    }

    /**
     * Get an existing post.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response) :Response
    {
        $post = $request->getAttribute('post');

        $parsedBody = $this->markdown->convertToHtml($post->getBody());
        $parsedBody = str_replace('<img', '<img class="img-fluid post-image"', $parsedBody);
        $post->setBody($parsedBody);

        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'post',
            [
                'sections' => Section::BLOG,
                'post' => $post,
                'imageData' => $this->getPostImageData($post),
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
    public function create(Request $request, Response $response) :Response
    {
        $tags = $this->tagResource->get();

        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'editor',
            [
                'sections' => Section::BLOG,
                'tagData' => json_encode(['tags' => $this->processTagData($tags)]),
                'imageData' => $this->getImageData(),
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
    public function store(Request $request, Response $response) :Response
    {
        $data = $request->getParsedBody();

        if (!$this->validator->isValid($data)) {
            return $response->withStatus(400);
        }

        $tags = $this->tagResource->process(
            array_key_exists('new_tags', $data) ? (is_array($data['new_tags']) ? $data['new_tags'] : []) : [],
            array_key_exists('tags', $data) ? (is_array($data['tags']) ? $data['tags'] : []) : []
        );

        $images = $this->imageResource->process(
            array_key_exists('images', $data) ? (is_string($data['images']) ? json_decode($data['images']) : []) : []
        );

        $user = $request->getAttribute('user');
        $slug = $this->postResource->create($data, $tags, $images, $user);

        return $response->withStatus(204)->withHeader('Location', '/blog/post/' . $slug);
    }

    /**
     * Edit an existing post.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function edit(Request $request, Response $response) :Response
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
                'imageData' => $this->getSelectedPostImageData($post),
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
    public function update(Request $request, Response $response) :Response
    {
        $data = $request->getParsedBody();

        if (!$this->validator->isValid($data)) {
            return $response->withStatus(400);
        }

        $tags = $this->tagResource->process(
            array_key_exists('new_tags', $data) ? (is_array($data['new_tags']) ? $data['new_tags'] : []) : [],
            array_key_exists('tags', $data) ? (is_array($data['tags']) ? $data['tags'] : []) : []
        );

        $images = $this->imageResource->process(
            array_key_exists('images', $data) ? (is_string($data['images']) ? json_decode($data['images']) : []) : []
        );

        $post = $request->getAttribute('post');
        $slug = $this->postResource->update($post, $data, $tags, $images);

        return $response->withStatus(204)->withHeader('Location', '/blog/post/' . $slug);
    }

    /**
     * Delete an existing post.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function delete(Request $request, Response $response) :Response
    {
        $post = $request->getAttribute('post');

        foreach($post->getPostTag() as $postTag) {
            $post->removePostTag($postTag);
        }

        foreach($post->getImages() as $postImage) {
            $post->removeImage($postImage);
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
    private function processTagData(array $tags) :array
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

    /**
     * Get the post images
     *
     * @param Post $post
     * @return string
     */
    private function getPostImageData(Post $post) :string
    {
        return A::create($post->getImages())->map(function (PostImage $postImage) {
            $image = $postImage->getImage();
            list($width, $height) = getimagesize('img/' . $image->getFilename() . '.jpg');
            return [
                'id' => $image->getId(),
                'src' => $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '1980']),
                'srcSet' => [
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '1024']) . '1024w',
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '800']) . '800w',
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '500']) . '500w',
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '320']) . '320w',
                ],
                'sizes' => [
                    '100vw'
                ],
                'height' => $height,
                'width' => $width,
                'title' => $image->getTitle() . ' - ' . $image->getCaption(),
                'alt' => $image->getTitle(),
            ];
        })->toJson();
    }

    /**
     * Get all images with post images selected
     *
     * @param Post $post
     * @return string
     */
    private function getSelectedPostImageData(Post $post) :string
    {
        return A::create($this->imageResource->get())->map(function (Image $image) use ($post) {
            $imageId = $image->getId();
            list($width, $height) = getimagesize('img/' . $image->getFilename() . '.jpg');
            return [
                'id' => $imageId,
                'src' => $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '1980']),
                'srcSet' => [
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '1024']) . '1024w',
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '800']) . '800w',
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '500']) . '500w',
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '320']) . '320w',
                ],
                'sizes' => [
                    '100vw'
                ],
                'height' => $height,
                'width' => $width,
                'title' => $image->getTitle() . ' - ' . $image->getCaption(),
                'alt' => $image->getTitle(),
                'selected' => A::create($image->getPosts())->map(function (PostImage $postImage) {
                    return $postImage->getPost();
                })->contains($post),
            ];
        })->toJson();
    }

    /**
     * Get all images
     *
     * @return string
     */
    private function getImageData() :string
    {
        return A::create($this->imageResource->get())->map(function (Image $image) {
            list($width, $height) = getimagesize('img/' . $image->getFilename() . '.jpg');
            return [
                'id' => $image->getId(),
                'src' => $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '1980']),
                'srcSet' => [
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '1024']) . '1024w',
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '800']) . '800w',
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '500']) . '500w',
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '320']) . '320w',
                ],
                'sizes' => [
                    '100vw'
                ],
                'height' => $height,
                'width' => $width,
                'title' => $image->getTitle() . ' - ' . $image->getCaption(),
                'alt' => $image->getTitle(),
            ];
        })->toJson();
    }
}
