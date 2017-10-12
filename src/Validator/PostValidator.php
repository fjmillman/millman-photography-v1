<?php declare(strict_types = 1);

namespace MillmanPhotography\Validator;

use Schemer\Validator as V;
use Schemer\Formatter as F;
use Schemer\Validator\ValidatorInterface;
use Schemer\Formatter\FormatterInterface;

class PostValidator implements Validator
{
    /** @var ValidatorInterface */
    private $validator;

    /** @var FormatterInterface */
    private $formatter;

    /** @var array */
    private $errors = [];

    public function __construct()
    {
        $this->validator = V::assoc([
            'Title' => V::text()->min(3)->max(50),
            'Description' => V::text()->min(3)->max(100),
            'Body' => V::text()->min(10),
        ]);

        $this->formatter = F::assoc([
            'title' => F::text(),
            'description' => F::text(),
            'body' => F::text(),
        ])->renameMany([
            'title' => 'Title',
            'description' => 'Description',
            'body' => 'Body',
        ]);
    }

    /**
     * @param array $postDetails
     * @return bool
     */
    public function isValid(array $postDetails) : bool
    {
        $detailsToValidate = $this->formatter->format($postDetails);
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
