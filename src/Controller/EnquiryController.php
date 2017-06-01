<?php

namespace MillmanPhotography\Controller;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

use MillmanPhotography\Resource\EnquiryResource;
use MillmanPhotography\Validator\EnquiryValidator;

class EnquiryController
{
    /** @var EnquiryValidator $validator */
    private $validator;

    /** @var EnquiryResource $resource */
    private $resource;

    /**
     * @param EnquiryValidator $validator
     * @param EnquiryResource $resource
     */
    public function __construct(EnquiryValidator $validator, EnquiryResource $resource)
    {
        $this->validator = $validator;
        $this->resource = $resource;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     */
    public function __invoke(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        if (!$this->validator->isValid($data)) {
            return $response->withJson($this->validator->getErrors(), 400);
        }

        try {
            $this->resource->create($data);
            return $response->withJson(['Success'], 200);
        } catch (\Exception $exception) {
            return $response->withJson(['Error: Try Again'], 404);
        }
    }
}
