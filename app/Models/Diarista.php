<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diarista extends Model
{
    use HasFactory;
    /**
     * Define os campos que podem ser gravados
     *
     * @var array
     */
    protected $fillable = ['nome_completo', 'cpf', 'email', 'telefone', 'logradouro', 'numero', 'bairro', 'cidade', 'estado', 'cep', 'codigo_ibge', 'foto_usuario'];

    /**
     * informa apenas os dados que serão exibidos na aplicação
     *
     * @var array
     */
    protected $visible = ['nome_completo', 'cidade', 'foto_usuario', 'reputacao'];

    /**
     * adiciona campos virtuais a serialização
     *
     * @var array
     */
    protected $appends = ['reputacao'];

    /**
     * onta url completa da imagem
     *
     * @param string $valor
     * @return void
     */
    public function getFotoUsuarioAttribute(string $valor)
    {
        return config('app.url').'/'.$valor;
    }

    /**
     * Acessor para reputacao. Retorna a reputação randomica
     *
     * @param [type] $valor
     * @return void
     */   
    public function getReputacaoAttribute($valor) 
    {
        return mt_rand(1,5);
    }

    /**
     * Busca Diaristas por codigo ibge
     *
     * @param integer $codigoIbge
     * @return void
     */
    static public function buscaPorCodigoIbge(int $codigoIbge)
    {
        //Diarista ou self
        //busca no banco ate 6 diarista com o mesmo codigo do IBGE
        return self::where('codigo_ibge', $codigoIbge)->limit(6)->get();
    }

    //verifica se tem outras diaristas cadastradas além das 6 limitadas da 1a consulta(limit(6)->get()) 
    static public function quantidadePorCodigoIbge(int $codigoIbge)
    {        
        $quantidade = self::where('codigo_ibge', $codigoIbge)->count();

        return $quantidade > 6 ? $quantidade-6 : 0;
    }
}


