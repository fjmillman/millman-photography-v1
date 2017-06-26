<?php

namespace MillmanPhotography\Validator;

use function Stringy\Create as S;
use Arrayzy\ArrayImitator as A;
use Respect\Validation\Validator as V;
use Respect\Validation\Exceptions\NestedValidationException;

class EnquiryValidator
{
    /** @var Validator $validator */
    private $validator;

    /** @var array $errors */
    private $errors = [];

    public function __construct()
    {
        $this->validator =
            V::key('name', V::stringType())
             ->key('email', V::stringType()->email())
             ->key('message', V::stringType());
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
