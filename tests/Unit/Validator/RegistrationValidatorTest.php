<?php declare(strict_types = 1);

namespace MillmanPhotography\Tests\Unit\Validator;

use PHPUnit\Framework\TestCase;

use MillmanPhotography\Validator\RegistrationValidator;

class RegistrationValidatorTest extends TestCase
{
    /**
     * @return void
     */
    public function testItPassesWhenNameUsernameAndPasswordAreValid()
    {
        $validator = new RegistrationValidator();

        $data = [
            'username' => 'username',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->assertTrue($validator->isValid($data));
        $this->assertEmpty($validator->getErrors());
    }

    /**
     * @return void
     */
    public function testItFailsWhenPasswordIsNotIdentical()
    {
        $validator = new RegistrationValidator();

        $data = [
            'username' => 'username',
            'password' => 'password',
            'password_confirmation' => 'passwrd',
        ];

        $expected = [
            'Passwords did not match!'
        ];

        $this->assertFalse($validator->isValid($data));
        $this->assertSame($expected, $validator->getErrors());
    }

    /**
     * @return void
     */
    public function testItFailsWhenPasswordIsTooShort()
    {
        $validator = new RegistrationValidator();

        $data = [
            'username' => 'username',
            'password' => 'pass',
            'password_confirmation' => 'pass',
        ];

        $expected = [
            'Password: not at least 7 characters',
            'Password confirmation: not at least 7 characters',
        ];

        $this->assertFalse($validator->isValid($data));
        $this->assertSame($expected, $validator->getErrors());
    }
}
