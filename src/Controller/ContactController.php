<?php

namespace MillmanPhotography\Controller;

use MillmanPhotography\Repository\ContactRepository;
use Projek\Slim\Monolog;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Validator\ContactValidator;

class ContactController
{
    /** @var ContactValidator $validator */
    private $validator;

    /** @var ContactRepository $repository */
    private $repository;

    /** @var Monolog $logger */
    private $logger;

    /**
     * @param ContactValidator $validator
     * @param ContactRepository $repository
     * @param Monolog $logger
     */
    public function __construct(ContactValidator $validator, ContactRepository $repository, Monolog $logger)
    {
        $this->validator = $validator;
        $this->repository = $repository;
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

        if (!$this->repository->store($data)) {
            return $response->withStatus(400)
                            ->withHeader('Content-type', 'application/json;charset=utf-8')
                            ->write(json_encode(['error']));
        };

        return $response->withStatus(200)
            ->withHeader('Content-type', 'application/json;charset=utf-8')
            ->write(json_encode(['success']));
    }
}
