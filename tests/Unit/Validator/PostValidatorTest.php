<?php

namespace MillmanPhotography\Tests\Unit\Validator;

use PHPUnit\Framework\TestCase;

use MillmanPhotography\Validator\PostValidator;

class PostValidatorTest extends TestCase
{
    /**
     * @return void
     */
    public function testItPassesWhenTitleDescriptionAndBodyAreValid()
    {
        $validator = new PostValidator();
        $data = [
            'title' => 'This is a Title',
            'description' => 'This is a description',
            'body' => 'This is the body of the blog post.',
        ];
        $this->assertTrue($validator->isValid($data));
        $this->assertEmpty($validator->getErrors());
    }
}
