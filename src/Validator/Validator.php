<?php declare(strict_types = 1);

namespace MillmanPhotography\Validator;

interface Validator
{
    /**
     * Check if the given data is valid
     *
     * @param array $data
     * @return bool
     */
    public function isValid(array $data) : bool;

    /**
     * Get the list of errors that will be populated by `isValid`
     *
     * @return array
     */
    public function getErrors() : array;
}
