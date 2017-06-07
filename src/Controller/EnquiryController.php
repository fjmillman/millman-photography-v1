<?php

namespace MillmanPhotography\Controller;

use Exception;
use Slim\Http\Request;
use Slim\Http\Response;
use Projek\Slim\Monolog;
use Swift_Message as SwiftMessage;
use Psr\Http\Message\ResponseInterface;

use MillmanPhotography\Mailer;
use MillmanPhotography\Resource\EnquiryResource;
use MillmanPhotography\Validator\EnquiryValidator;
use MillmanPhotography\Exception\MailerException;

class EnquiryController
{
    /** @var EnquiryValidator $validator */
    private $validator;

    /** @var EnquiryResource $resource */
    private $resource;

    /** @var Mailer $mailer */
    private $mailer;

    /** @var Monolog $logger */
    private $logger;

    /**
     * @param EnquiryValidator $validator
     * @param EnquiryResource $resource
     * @param Mailer $mailer
     * @param Monolog $logger
     */
    public function __construct(
        EnquiryValidator $validator,
        EnquiryResource $resource,
        Mailer $mailer,
        Monolog $logger
    ) {
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

            $this->mailer->send('emails/reply', ['enquiry' => $enquiry],
                function (SwiftMessage $message) use ($enquiry) {
                    $message->setFrom('freddie.john.millman@millmanphotography.co.uk', 'Millman Photography')
                        ->setTo($enquiry->getEmail(), $enquiry->getName())
                        ->setReplyTo('freddie.john.millman@millmanphotography.co.uk', 'Millman Photography')
                        ->setSubject('Millman Photography Enquiry');
                }
            );

            $this->mailer->send('emails/enquiry', ['enquiry' => $enquiry],
                function (SwiftMessage $message) use ($enquiry) {
                    $message->setFrom($enquiry->getEmail(), $enquiry->getName())
                        ->setTo('freddie.john.millman@millmanphotography.co.uk', 'Millman Photography')
                        ->setReplyTo($enquiry->getEmail(), $enquiry->getName())
                        ->setSubject('Millman Photography Enquiry');
                }
            );

            return $response->withJson(['Success'], 200);
        } catch (MailerException $exception) {
            $this->logger->log(100, $exception->getMessage() . ' in ' . $exception->getFile() . $exception->getLine());
            return $response->withJson(['Success: No Email Sent'], 200);
        } catch (Exception $exception) {
            $this->logger->log(100, $exception->getMessage() . ' in ' . $exception->getFile() . $exception->getLine());
            return $response->withJson(['Error: Try Again'], 404);
        }
    }
}
