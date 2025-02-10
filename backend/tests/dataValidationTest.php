<?php

  use PHPUnit\Framework\Attributes\DataProvider;
  use PHPUnit\Framework\TestCase;

  require_once('./php/functions/validation.php');

  class DataValidationTest extends TestCase{


    protected function setUp(): void{
    }

    public function testRequiredField(){
      $this->assertEquals("Pole email jest wymagane.", validateField(null, 'email'));
      $this->assertEquals("Pole hasło jest wymagane.", validateField(false, 'hasło'));
      $this->assertEquals(null, validateField('test', 'hasło'));
    }

    public function testPasswordMatch(){
        $this->assertEquals(null, validPasswordAndPlainPassword('Haslo123', 'Haslo123'));
        $this->assertEquals("Hasła muszą być takie same.", validPasswordAndPlainPassword('Haslo123', 'Haslo321'));
    }

    #[DataProvider('fieldRegexProvider')]
    public function testFieldRegex($return, $dataToValid, string $name, $required, $regex){
        $this->assertEquals($return, validateField($dataToValid, $name, $required, $regex));
    }

    public static function fieldRegexProvider(){
      return array(
        array(null, 'test@example.com', 'email', true, '/^[^@\s]+@[^@\s]+\.[^@\s]+$/'),
        array('Pole email ma nieprawidłowy format.', 'testexample.com', 'email', true, '/^[^@\s]+@[^@\s]+\.[^@\s]+$/'),
        array(null, '11-111', 'kod pocztowy', true, '/^\d{2}-\d{3}$/'),
        array('Pole kod pocztowy ma nieprawidłowy format.', '111-111', 'kod pocztowy', true, '/^\d{2}-\d{3}$/'),
      );
    }

    public function testMaxLength(){
      $this->assertEquals(null, validateField('12345', 'kod', true, null, 6));
      $this->assertEquals("Pole kod przekracza maksymalną długość 5 znaków.", validateField('123456', 'kod', true, null, 5));
    }

    public function testMinLength(){
      $this->assertEquals(null, validateField('123456', 'hasło', true, null, null, 3));
      $this->assertEquals("Pole hasło nie przekracza minimalnej długości 3 znaków.", validateField('12', 'hasło', true, null, null, 3));
    }

  }