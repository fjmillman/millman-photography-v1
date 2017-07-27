<?php

namespace MillmanPhotography\Validator;

use Arrayzy\ArrayImitator as A;
use function Stringy\Create as S;
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
            V::key('title', V::stringType()->length(3, 25))
             ->key('description', V::stringType()->length(3, 50))
             ->key('body', V::stringType()->length(10));
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
            $this->errors = A::create($exception->getMessages())->map(function ($message) {
                return (string) S($message)->upperCaseFirst();
            })->toArray();
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
