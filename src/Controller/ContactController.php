<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Monolog;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Resource\ContactResource;
use MillmanPhotography\Validator\ContactValidator;

class ContactController
{
    /** @var ContactValidator $validator */
    private $validator;

    /** @var ContactResource $resource */
    private $resource;

    /** @var Monolog $logger */
    private $logger;

    /**
     * @param ContactValidator $validator
     * @param ContactResource $resource
     * @param Monolog $logger
     */
    public function __construct(ContactValidator $validator, ContactResource $resource, Monolog $logger)
    {
        $this->validator = $validator;
        $this->resource = $resource;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __invoke(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        if (!$this->validator->isValid($data)) {
            return $response->withStatus(400)
                ->withHeader('Content-type', 'application/json;charset=utf-8')
                ->write(json_encode($this->validator->getErrors()));
        };

        if (!$this->resource->create($data)) {
            return $response->withStatus(400)
                            ->withHeader('Content-type', 'application/json;charset=utf-8')
                            ->write(json_encode(['error']));
        };

        return $response->withStatus(200)
            ->withHeader('Content-type', 'application/json;charset=utf-8')
            ->write(json_encode(['success']));
    }
}
