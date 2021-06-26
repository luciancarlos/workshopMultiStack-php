<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ViaCEP
{
    /**
     * Consulta CEP
     * @param string $cep
     * @return bool|array
     */
    public function buscar(string $cep)
    {
        $url = sprintf('https://viacep.com.br/ws/%s/json/',$cep); //%s substitui pela variavel $cep recebida no parametro

        //a requisicao é http que precisa de um client http, o laravel tem um clint padrão('composer require guzzlehttp/guzzle')
        $resposta = Http::get($url); //requisição ao ViaCEP por get

        //dd($resposta);

        //retorno 200 ok. Se retorno diferente de 200 = falha
        if($resposta->failed()){
            return false;
        }

        $dados = $resposta->json(); //pega o json vindo do viaCEP e transforma num array

        if(isset($dados['erro']) && $dados['erro'] === true){
            return false;
        }

        return $dados;
    }

}