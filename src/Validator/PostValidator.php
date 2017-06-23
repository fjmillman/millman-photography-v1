<?php

namespace MillmanPhotography\Validator;

use Respect\Validation\Validator as V;
use Respect\Validation\Exceptions\NestedValidationException;

class PostValidator
{
    /** @var Validator $validator */
    private $validator;

    /** @var array $errors */
    private $errors = [];

    public function __construct()
    {
        $this->validator =
            V::key('title', V::stringType()->min(3)->max(50))
             ->key('body', V::stringType()->min(10));
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
