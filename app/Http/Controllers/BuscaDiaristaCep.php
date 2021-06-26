<?php

namespace App\Http\Controllers;

use App\Models\Diarista;
use App\Services\ViaCEP;
use Illuminate\Http\Request;

class BuscaDiaristaCep extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // __invoke criar controller com uma unica ação
    public function __invoke(Request $request, ViaCEP $viaCEP)
    {
        $endereco =   $viaCEP->buscar($request->cep);

        if($endereco === false){
            return response()->json(['erro'=>'CEP inválido'],400);
        }
        
        //$diaristas = Diarista::buscaPorCodigoIbge($endereco['ibge']);
        return [
            'diaristas' =>Diarista::buscaPorCodigoIbge($endereco['ibge']),
            'quatidade_diaristas' => Diarista::quantidadePorCodigoIbge($endereco['ibge'])
        ]; //retorno serializado para json (padrão Laravel)
      
        //entrada codigo do ibge
        //lista de diaristas filtradas pelo codigo
    }
}
