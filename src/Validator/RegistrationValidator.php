<?php

namespace MillmanPhotography\Validator;

use Respect\Validation\Validator as V;
use Respect\Validation\Exceptions\NestedValidationException;

class RegistrationValidator
{
    /** @var Validator $validator */
    private $validator;

    /** @var array $errors */
    private $errors = [];

    public function __construct()
    {
        $this->validator = V::assoc([
            'Username' => V::text()->min(3)->max(32),
            'Password' => V::text()->min(7),
            'Password Confirmation' => V::text()->min(7),
        ])->should(function ($data) {
                return $data['Password'] === $data['Password Confirmation'];
            },
            'Passwords did not match!'
        );

        $this->validator =
            V::key('username', V::stringType()->min(3)->max(32))
             ->key('password', V::stringType()->min(7))
             ->key('password_confirmation', V::stringType()->min(7));
    }

    /**
     * @param array $data
     * @return bool
     */
    public function isValid(array $data)
    {
        try {
            return $this->validator->assert($data);
        } catch (NestedValidationException $exception) {
            $this->errors = $exception->getMessages();
            return false;
        }
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
