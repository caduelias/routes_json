<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Faker\Factory;
use App\Exceptions\RequestException;
use Exception;

class PersonController extends Controller
{
    /**
     * @var Faker
     */
    private $generatePerson;
    
    public function __construct()
    {
        $this->generatePerson = Factory::create('pt_BR');
    }

    /**
     * @return string
     */
    public function generatePerson(): string
    {
        try {
            $person = new \stdClass();
            $person->nome = $this->generatePerson->name;
            $person->cpf = $this->generatePerson->cpf;
            $person->rg = $this->generatePerson->rg;
            $person->telefone = $this->generatePerson->phoneNumber;
            return json_encode($person);
        } catch (Exception $e) {
            throw new RequestException("Erro ao gerar pessoa!", 500);
        }
    }
}