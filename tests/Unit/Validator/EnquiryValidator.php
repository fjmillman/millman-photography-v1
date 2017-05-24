<?php

namespace MillmanPhotography\Tests\Unit\Validator;

use PHPUnit\Framework\TestCase;

use MillmanPhotography\Validator\EnquiryValidator;

class EnquiryValidatorTest extends TestCase
{
    /**
     * @return void
     */
    public function testItPassesWhenNameEmailAndMessageAreValid()
    {
        $validator = new EnquiryValidator();
        $data = [
            'name' => 'This Is-A Name',
            'email' => 'this.is@an.email',
            'message' => 'This is a message.'
        ];
        $this->assertTrue($validator->isValid($data));
        $this->assertEmpty($validator->getErrors());
    }

    /**
     * @return void
     */
    public function testItFailsWhenEmailIsInvalid()
    {
        $validator = new EnquiryValidator();
        $data = [
            'name' => 'This Is-A Name',
            'email' => 'this.is.an.email',
            'message' => 'This is a message.'
        ];
        $this->assertFalse($validator->isValid($data));
        $this->assertSame('email: not an email', $validator->getErrors());
    }
}
