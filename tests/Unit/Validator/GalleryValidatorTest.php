<?php declare(strict_types = 1);

namespace MillmanPhotography\Tests\Unit\Validator;

use PHPUnit\Framework\TestCase;

use MillmanPhotography\Validator\GalleryValidator;

class GalleryValidatorTest extends TestCase
{
    /**
     * @return void
     */
    public function testItPassesWhenTitleAndDescriptionAreValid() : void
    {
        $validator = new GalleryValidator();
        $data = [
            'title' => 'This is a Title',
            'description' => 'This is a description.',
        ];
        $this->assertTrue($validator->isValid($data));
        $this->assertEmpty($validator->getErrors());
    }

    /**
     * @return void
     */
    public function testItFailsWhenTitleIsEmpty() : void
    {
        $validator = new GalleryValidator();
        $data = [
            'title' => '',
            'description' => 'This is a description.',
        ];
        $expected = [
            'Title: not at least 3 characters'
        ];
        $this->assertFalse($validator->isValid($data));
        $this->assertSame($expected, $validator->getErrors());
    }
}
