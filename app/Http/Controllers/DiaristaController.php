<?php

namespace App\Http\Controllers;

use App\Models\Diarista;
use Illuminate\Http\Request;

class DiaristaController extends Controller
{
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

    public function store(Request $request)
    {
        $dados = $request->except('_token');
        /* nao recebe o valor do token  */
        $dados['foto_usuario']=$request->foto_usuario->store('public');

        Diarista::create($dados); /* array com dados */

        return redirect()->route('diaristas.index'); /* volta para a lista de diaristas */
        
    }

    public function edit(int $id)
    {
        $diarista = Diarista::findOrfail($id);
        //busca diarista no banco, se achar retorna a diarista, senão retorna um 404
        return view('edit', ['diarista' => $diarista]);
    }
}
 