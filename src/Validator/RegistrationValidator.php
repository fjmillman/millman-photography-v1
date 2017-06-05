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
        ])->renameMany([
            'username' => 'Username',
            'password' => 'Password',
            'password_confirmation' => 'Password Confirmation'
        ]);

        $this->validator = V::assoc([
            'Username' => V::text()->min(3)->max(32),
            'Password' => V::text()->min(7),
            'Password Confirmation' => V::text()->min(7),
        ])->should(function ($data) {
                return $data['Password'] === $data['Password Confirmation'];
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
