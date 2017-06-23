<?php

namespace MillmanPhotography\Validator;

interface Validator
{
    /**
     * @param array $data
     * @return bool
     */
    public function isValid(array $data);

    /**
     * @return array
     */
    public function getErrors();
}
