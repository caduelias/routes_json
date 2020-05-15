<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Faker\Factory;
use App\Exceptions\RequestException;
use Exception;

class CardController extends Controller
{
    /**
     * @var Faker
     */
    private $generateCard;
    
    /**
     * @var array
     */
    private $flags = ['visa' => 'Visa',
                      'diners' => 'Diners',
                      'master' => 'MasterCard',
                      'amex' => 'American Express'
                    ];

    public function __construct()
    {
        $this->generateCard = Factory::create('pt_BR');
    }
  
    /**
     * @return array
     */
    public function generateCardNumber(): string
    {
        try {
            $flag = strtolower(strval(request()->route()->parameters['bandeira']));

            if (!array_key_exists($flag, $this->flags)) {
                throw new RequestException("Parâmetro {bandeira}" . $flag . " inválido!", 400);
            }
    
            foreach ($this->flags as $key => $value) {
                if ($flag == $key) {
                    $card = new \stdClass();
                    $card->bandeira = $value;
                    $card->numero =$this->generateCard->creditCardNumber($value);
                    return json_encode($card);
                }
            }
        } catch (Exception $e) {
            throw new Exception("Erro ao gerar cartão!", 500);
        }
    }
}