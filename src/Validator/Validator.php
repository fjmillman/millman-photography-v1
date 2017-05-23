<?php

namespace MillmanPhotography\Validator;

interface Validator
{
    /**
     * Check if the given data is valid. This *must* be called before `getErrors`
     *
     * @param array $data
     * @return bool
     */
    public function isValid(array $data);

    /**
     * Get the list of errors that will be populated by `isValid`
     *
     * @return array
     */
    public function getErrors();
}
