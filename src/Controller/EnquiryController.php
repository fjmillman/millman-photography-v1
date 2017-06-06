<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Monolog;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Http\Message\ResponseInterface;

use MillmanPhotography\Mail\Mailer;
use MillmanPhotography\Mail\Message;
use MillmanPhotography\Resource\EnquiryResource;
use MillmanPhotography\Validator\EnquiryValidator;

class EnquiryController
{
    /** @var EnquiryValidator $validator */
    private $validator;

    /** @var EnquiryResource $resource */
    private $resource;

    /** @var Mailer $mailer */
    private $mailer;

    private $logger;

    /**
     * @param EnquiryValidator $validator
     * @param EnquiryResource $resource
     * @param Mailer $mailer
     * @param Monolog $logger
     */
    public function __construct(EnquiryValidator $validator, EnquiryResource $resource, Mailer $mailer, Monolog $logger)
    {
        $this->validator = $validator;
        $this->resource = $resource;
        $this->mailer = $mailer;
        $this->logger = $logger;
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
            $enquiry = $this->resource->create($data);
            $this->mailer->send('emails/reply', ['enquiry' => $enquiry], function (Message $message) use ($enquiry) {
                $message->to($enquiry->getEmail());
                $message->subject('Millman Photography Enquiry');
            });
            $this->mailer->send('emails/enquiry', ['enquiry' => $enquiry], function (Message $message) use ($enquiry) {
                $message->to('freddie.millman@icloud.com');
                $message->subject('Millman Photography Enquiry');
            });
            return $response->withJson(['Success'], 200);
        } catch (\Exception $exception) {
            $this->logger->log(100, $exception->getMessage() . ' in ' . $exception->getFile() . $exception->getLine());
            return $response->withJson(['Error: Try Again'], 404);
        }
    }
}
