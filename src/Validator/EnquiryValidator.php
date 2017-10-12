<?php declare(strict_types = 1);

namespace MillmanPhotography\Validator;

use Schemer\Validator as V;
use Schemer\Formatter as F;
use Schemer\Validator\ValidatorInterface;
use Schemer\Formatter\FormatterInterface;

class EnquiryValidator implements Validator
{
    /** @var ValidatorInterface */
    private $validator;

    /**  @var FormatterInterface */
    private $formatter;

    /** @var array */
    private $errors = [];

    public function __construct()
    {
        $this->validator = V::assoc([
            'Name' => V::text()->max(50),
            'Email' => V::text()->email(),
            'Message' => V::text()->min(3)->max(250),
        ]);

        $this->formatter = F::assoc([
            'name' => F::text(),
            'email' => F::text(),
            'message' => F::text(),
        ])->renameMany([
            'name' => 'Name',
            'email' => 'Email',
            'message' => 'Message',
        ]);
    }

    /**
     * @param array $enquiryDetails
     * @return bool
     */
    public function isValid(array $enquiryDetails) : bool
    {
        $detailsToValidate = $this->formatter->format($enquiryDetails);
        $result = $this->validator->validate($detailsToValidate);
        $this->errors = $result->errors();
        return !$result->isError();
    }

    /**
     * @return array
     */
    public function getErrors() : array
    {
        return $this->errors;
    }
}
