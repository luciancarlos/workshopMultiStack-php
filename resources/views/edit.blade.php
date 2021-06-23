@extends('app')

@section('titulo', 'Editar Diarista' )

@section('conteudo')
<h1>Editar Diarista</h1>
    <form action="{{route('diaristas.store')}}" method="POST" enctype="multipart/form-data">
    
        @include('_form')
        
    </form>      
@endsection