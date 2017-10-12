<?php declare(strict_types = 1);

namespace MillmanPhotography\Validator;

use Schemer\Validator as V;
use Schemer\Formatter as F;
use Schemer\Validator\ValidatorInterface;
use Schemer\Formatter\FormatterInterface;

class ImageValidator implements Validator
{
    /** @var ValidatorInterface */
    private $validator;

    /**  @var FormatterInterface */
    private $formatter;

    /** @var array */
    private $errors = [];

    public function __construct()
    {
        $this->validator = V::assoc([
            'Title' => V::text()->min(3)->max(50),
            'Caption' => V::text()->min(3)->max(100),
        ]);

        $this->formatter = F::assoc([
            'title' => F::text(),
            'caption' => F::text(),
            'is_favourite' => F::boolean(),
        ])->renameMany([
            'title' => 'Title',
            'caption' => 'Caption',
        ]);
    }

    /**
     * @param array $imageDetails
     * @return bool
     */
    public function isValid(array $imageDetails) : bool
    {
        $detailsToValidate = $this->formatter->format($imageDetails);
        $result = $this->validator->validate($detailsToValidate);
        $this->errors = $result->errors();
        return !$result->isError();
    }

    /**
     * @return array
     */
    public function getErrors() : array
    {
        return $this->errors;
    }
}
