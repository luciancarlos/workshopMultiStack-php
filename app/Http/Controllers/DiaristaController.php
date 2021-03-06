<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiaristaRequest;
use App\Models\Diarista;
use App\Services\ViaCEP;
use Illuminate\Http\Request;

class DiaristaController extends Controller
{
    //Definindo ViaCEP no construtor
    public function __construct(
        protected ViaCEP $viaCep
    ){

    }
    
    public function index()
    {
        
        $diaristas = Diarista::get(); //passando os dados para view
        return view('index', [
            'diaristas' => $diaristas
        ]);
    }

    public function create()
    {
        return view('create');
    }

    public function store(DiaristaRequest $request)
    {
        $dados = $request->except('_token');
        /* nao recebe o valor do token  */
        $dados['foto_usuario']=$request->foto_usuario->store('public');

        $dados['cpf'] = str_replace(['.','-'],'',$dados['cpf']);
        $dados['cep'] = str_replace('-','',$dados['cep']);
        $dados['telefone'] = str_replace(['(',')',' ','-'],'',$dados['telefone']);

        $dados['codigo_ibge'] = $this->viaCep->buscar($dados['cep'])['ibge'];

        Diarista::create($dados); /* array com dados */

        return redirect()->route('diaristas.index'); /* volta para a lista de diaristas */
        
    }

    public function edit(int $id)
    {
        $diarista = Diarista::findOrfail($id);
        //busca diarista no banco, se achar retorna a diarista, senão retorna um 404
        return view('edit', ['diarista' => $diarista]);
    }

    public function update(int $id, DiaristaRequest $request) //dados no banco de dados
    {
        $diarista = Diarista::findOrfail($id);

        $dados = $request->except(['_token', '_method']);

        $dados['cpf'] = str_replace(['.','-'],'',$dados['cpf']);
        $dados['cep'] = str_replace('-','',$dados['cep']);
        $dados['telefone'] = str_replace(['(',')',' ','-'],'',$dados['telefone']);
        
        $dados['codigo_ibge'] = $this->viaCep->buscar($dados['cep'])['ibge'];

        //verificar se tem imagem
        if($request->hasFile('foto_usuario')){
            $dados['foto_usuario'] = $request->foto_usuario->store('public');
        }

        $diarista->update($dados); //atualiza a diarista

        return redirect()->route('diaristas.index');

    }

    public function destroy(int $id)
    {
        $diarista = Diarista::findOrfail($id);

        $diarista->delete();

        return redirect()->route('diaristas.index');
    }
}
 