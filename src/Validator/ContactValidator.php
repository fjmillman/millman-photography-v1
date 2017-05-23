<?php

namespace MillmanPhotography\Validator;

use Schemer\Validator as V;
use Schemer\Formatter as F;
use Schemer\Validator\ValidatorInterface;
use Schemer\Formatter\FormatterInterface;

class ContactValidator implements Validator
{
    /** @var FormatterInterface $formatter */
    private $formatter;

    /** @var ValidatorInterface $validator */
    private $validator;

    /** @var array $errors */
    private $errors = [];

    public function __construct()
    {
        $this->formatter = F::assoc([
            'name' => F::text(),
            'email' => F::text(),
            'message' => F::text(),
        ])->only([
            'name',
            'email',
            'message'
        ]);

        $this->validator = V::assoc([
            'name' => V::text()->alphanum(),
            'email' => V::text()->email(),
            'message' => V::text(),
        ]);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function isValid(array $data)
    {
        $data = $this->formatter->format($data);
        $result = $this->validator->validate($data);
        $this->errors = $result->errors();
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
