<?php

namespace MillmanPhotography\Validator;

use Schemer\Validator as V;
use Schemer\Formatter as F;
use Schemer\Validator\ValidatorInterface;
use Schemer\Formatter\FormatterInterface;

class RegistrationValidator implements Validator
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
            'username' => F::text(),
            'password' => F::text(),
            'password_confirmation' => F::text(),
        ])->only([
            'username',
            'password',
            'password_confirmation',
        ]);

        $this->validator = V::assoc([
            'username' => V::text()->min(3)->max(32),
            'password' => V::text()->min(7),
            'password_confirmation' => V::text()->min(7),
        ])->should(function ($data) {
                return $data['password'] === $data['password_confirmation'];
            },
            'Passwords did not match!'
        );
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
