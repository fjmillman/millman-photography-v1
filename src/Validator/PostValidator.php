<?php

namespace MillmanPhotography\Validator;

use Schemer\Validator as V;
use Schemer\Validator\ValidatorInterface;
use Schemer\Formatter\FormatterInterface;

class PostValidator implements Validator
{
    /** @var FormatterInterface $formatter */
    private $formatter;

    /** @var ValidatorInterface $validator */
    private $validator;

    /** @var array $errors */
    private $errors = [];

    public function __construct()
    {
        $this->validator = V::assoc([
            'title' => V::text()->min(3)->max(50),
            'body' => V::text()->min(10),
        ]);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function isValid(array $data)
    {
        $result = $this->validator->validate($data);
        $this->errors = $result->map('ucfirst')->errors();
        return !$result->isError();
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
