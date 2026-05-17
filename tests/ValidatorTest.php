<?php 

use PHPUnit\Framework\TestCase;
use App\Core\Validator;

class ValidatorTest extends TestCase {

    public function testTituloObrigatorio() {
        $data  = ['titulo' => ''];
        $rules = ['titulo' => ['required'],];


        $errors = Validator::validate($data, $rules);
        $this->assertArrayHasKey('titulo', $errors);
    }

    public function testTituloValido() {
        $data  = ['titulo' => 'Zelda'];
        $rules = ['titulo' => ['required']];

        $errors = Validator::validate($data,$rules);
        $this->assertEmpty($errors);
    }

    public function testNotaValida() {
        $data  = ['nota' => '8'];
        $rules = ['nota' => ['required', 'number', 'min:0', 'max:10']];

        $errors = Validator::validate($data,$rules);
        $this->assertEmpty($errors);
    }

    public function testNotaDeveSerNumerica() {
        $data  = ['nota' => 'abc'];
        $rules = ['nota' => ['required', 'number']];

        $errors = Validator::validate($data, $rules);
        $this->assertArrayHasKey('nota', $errors);
    }

    public function testNotaMinima() {
        $data  = ['nota' => -1];
        $rules = ['nota' => ['min:0']];

        $errors = Validator::validate($data, $rules);
        $this->assertArrayHasKey('nota', $errors)        ;
    }

    public function testNotaMaxima() {
        $data  = ['nota' => 11];
        $rules = ['nota' => ['max:10']];

        $errors = Validator::validate($data, $rules);
        $this->assertArrayHasKey('nota', $errors)        ;
    }
}

?>