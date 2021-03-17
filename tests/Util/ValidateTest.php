<?php


namespace App\Tests\Util;

use App\Util\Validate;
use PHPUnit\Framework\TestCase;

class ValidateTest extends TestCase
{
    public function testValidEmail(): void
    {
        $validator = new Validate([
            'email' => 'test@mail.com',
        ]);

        $validator->expect("email", "email");

        $result = $validator->validate();
        $this->assertEquals(true, $result);
    }

    public function testEmptyEmail(): void
    {
        $validator = new Validate([
            'email' => '',
        ]);

        $validator->expect("email", "email");

        $result = $validator->validate();
        $this->assertEquals(false, $result);
    }

    public function testNoValidEmail(): void
    {
        $validator = new Validate([
            'email' => 'test',
        ]);

        $validator->expect("email", "email");

        $result = $validator->validate();
        $this->assertEquals(false, $result);
    }

    public function testNoFullEmail(): void
    {
        $validator = new Validate([
            'email' => 'test@',
        ]);

        $validator->expect("email", "email");

        $result = $validator->validate();
        $this->assertEquals(false, $result);
    }

    public function testValidRequired(): void
    {
        $validator = new Validate([
            'name' => 'test text',
        ]);

        $validator->expect("name", "required");

        $result = $validator->validate();
        $this->assertEquals(true, $result);
    }

    public function testNoValidRequired(): void
    {
        $validator = new Validate([
            'name' => '',
        ]);

        $validator->expect("name", "required");

        $result = $validator->validate();
        $this->assertEquals(false, $result);
    }

    public function testValidStrNumeric(): void
    {
        $validator = new Validate([
            'name' => '8',
        ]);

        $validator->expect("name", "numeric");

        $result = $validator->validate();
        $this->assertEquals(true, $result);
    }

    public function testValidIntNumeric(): void
    {
        $validator = new Validate([
            'name' => 10,
        ]);

        $validator->expect("name", "numeric");

        $result = $validator->validate();
        $this->assertEquals(true, $result);
    }

    public function testNoValidNumeric(): void
    {
        $validator = new Validate([
            'name' => 'text',
        ]);

        $validator->expect("name", "numeric");

        $result = $validator->validate();
        $this->assertEquals(false, $result);
    }

    public function testEmptyNumeric(): void
    {
        $validator = new Validate([
            'name' => '',
        ]);

        $validator->expect("name", "numeric");

        $result = $validator->validate();
        $this->assertEquals(false, $result);
    }

    public function testValidNumStrInteger(): void
    {
        $validator = new Validate([
            'number' => '8',
        ]);

        $validator->expect("number", "integer");

        $result = $validator->validate();
        $this->assertEquals(true, $result);
    }

    public function testValidInteger(): void
    {
        $validator = new Validate([
            'number' => 10,
        ]);

        $validator->expect("number", "integer");

        $result = $validator->validate();
        $this->assertEquals(true, $result);
    }

    public function testNoValidInteger(): void
    {
        $validator = new Validate([
            'number' => 'test',
        ]);

        $validator->expect("number", "integer");

        $result = $validator->validate();
        $this->assertEquals(false, $result);
    }

    public function testEmptyInteger(): void
    {
        $validator = new Validate([
            'number' => '',
        ]);

        $validator->expect("number", "integer");

        $result = $validator->validate();
        $this->assertEquals(false, $result);
    }

    public function testValidNumStrFloat(): void
    {
        $validator = new Validate([
            'number' => '8.2',
        ]);

        $validator->expect("number", "float");

        $result = $validator->validate();
        $this->assertEquals(true, $result);
    }

    public function testValidFloat(): void
    {
        $validator = new Validate([
            'number' => 10.5,
        ]);

        $validator->expect("number", "float");

        $result = $validator->validate();
        $this->assertEquals(true, $result);
    }

    public function testNoValidFloat(): void
    {
        $validator = new Validate([
            'number' => 'test',
        ]);

        $validator->expect("number", "float");

        $result = $validator->validate();
        $this->assertEquals(false, $result);
    }

    public function testEmptyFloat(): void
    {
        $validator = new Validate([
            'number' => '',
        ]);

        $validator->expect("number", "float");

        $result = $validator->validate();
        $this->assertEquals(false, $result);
    }

    public function testValidMinVal(): void
    {
        $validator = new Validate([
            'number' => '14',
        ]);

        $validator->expect("number", "min_val=15");

        $result = $validator->validate();
        $this->assertEquals(false, $result);
    }

    public function testNoValidMinVal(): void
    {
        $validator = new Validate([
            'number' => '16',
        ]);

        $validator->expect("number", "min_val=15");

        $result = $validator->validate();
        $this->assertEquals(true, $result);
    }

    public function testValidMinLength(): void
    {
        $validator = new Validate([
            'line' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit',
        ]);

        $validator->expect("line", "min_length=15");

        $result = $validator->validate();
        $this->assertEquals(true, $result);
    }

    public function testNoValidMinLength(): void
    {
        $validator = new Validate([
            'line' => 'Lorem ipsum',
        ]);

        $validator->expect("line", "min_length=15");

        $result = $validator->validate();
        $this->assertEquals(false, $result);
    }

    public function testValidMaxLength(): void
    {
        $validator = new Validate([
            'line' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit',
        ]);

        $validator->expect("line", "max_length=20");

        $result = $validator->validate();
        $this->assertEquals(false, $result);
    }

    public function testNoValidMaxLength(): void
    {
        $validator = new Validate([
            'line' => 'Lorem ipsum dolor',
        ]);

        $validator->expect("line", "max_length=20");

        $result = $validator->validate();
        $this->assertEquals(true, $result);
    }

    public function testValidConfirm(): void
    {
        $validator = new Validate([
            'password' => 'qwertY12',
            'password_confirm' => 'qwertY12'
        ]);

        $validator->expect("password", "confirm=password_confirm");

        $result = $validator->validate();
        $this->assertEquals(true, $result);
    }

    public function testNoValidConfirm(): void
    {
        $validator = new Validate([
            'password' => 'qwertY12',
            'password_confirm' => 'qwertY'
        ]);

        $validator->expect("password", "confirm=password_confirm");

        $result = $validator->validate();
        $this->assertEquals(true, $result);
    }

    public function testNotUseRule(): void
    {
        $validator = new Validate([
            'name' => '',
        ]);

        $rule = "blabla";
        $validator->expect("name", "blabla");

        $result = $validator->validate();
        $this->assertEquals(false, $result);

        $errors = $validator->getErrors();
        $this->assertContains('No exist valid rule ' . $rule, $errors['error'], "testArray doesn't contains value as value") ;
    }
}