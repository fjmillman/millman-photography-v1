<?php

namespace MillmanPhotography\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use Projek\Slim\Monolog;

use MillmanPhotography\Resource\EnquiryResource;
use MillmanPhotography\Validator\EnquiryValidator;

class EnquiryController
{
    /** @var EnquiryValidator $validator */
    private $validator;

    /** @var EnquiryResource $resource */
    private $resource;

    /** @var Monolog $logger */
    private $logger;

    /**
     * @param EnquiryValidator $validator
     * @param EnquiryResource $resource
     * @param Monolog $logger
     */
    public function __construct(EnquiryValidator $validator, EnquiryResource $resource, Monolog $logger)
    {
        $this->validator = $validator;
        $this->resource = $resource;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        if (!$this->validator->isValid($data)) {
            return $response->withJson($this->validator->getErrors(), 400);
        }

        try {
            $this->resource->create($data);
            return $response->withJson(['Sent'], 200);
        } catch (\Exception $exception) {
            $this->logger->log(100, $exception->getMessage());
            return $response->withJson(['Error'], 400);
        }
    }
}
