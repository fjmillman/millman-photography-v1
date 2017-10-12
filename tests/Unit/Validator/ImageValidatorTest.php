<?php declare(strict_types = 1);

namespace MillmanPhotography\Tests\Unit\Validator;

use PHPUnit\Framework\TestCase;

use MillmanPhotography\Validator\ImageValidator;

class ImageValidatorTest extends TestCase
{
    /**
     * @return void
     */
    public function testItPassesWhenNameTitleAndCaptionAreValid()
    {
        $validator = new ImageValidator();
        $data = [
            'title' => 'This is a Title',
            'caption' => 'This is a caption.',
        ];
        $this->assertTrue($validator->isValid($data));
        $this->assertEmpty($validator->getErrors());
    }

    /**
     * @return void
     */
    public function testItFailsWhenTitleIsInvalid()
    {
        $validator = new ImageValidator();

        $data = [
            'title' => '',
            'caption' => 'This is a caption.',
        ];

        $expected = [
            'Title: not at least 3 characters',
        ];

        $this->assertFalse($validator->isValid($data));
        $this->assertSame($expected, $validator->getErrors());
    }
}
