@extends('layouts.app')

@push('styles')
    <style>
        .deputado-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .deputado-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .deputado-header h2 {
            font-size: 24px;
            color: #333;
            font-weight: 600;
        }

        .info-group {
            margin-bottom: 20px;
        }

        .info-group label {
            display: block;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .info-group input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-top: 8px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .info-group input:focus {
            border-color: #4caf50;
            outline: none;
        }

        .info-group input[type="date"] {
            padding: 10px;
        }

        button {
            width: 100%;
            padding: 12px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }

        .back-button {
            margin-top: 30px;
            text-align: center;
        }

        .back-button a {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .back-button a:hover {
            background-color: #45a049;
        }
    </style>
@endpush

@section('content')
<div class="deputado-container">
    <div class="deputado-header">
        <h2>Editar Deputado: {{ $deputado->nome }}</h2>
    </div>

    <!-- Formulário de Edição -->
    <form action="{{ route('deputadosfic.update', $deputado->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Método PUT para a atualização -->

        <div class="info-group">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="{{ old('nome', $deputado->nome) }}" required>
        </div>

        <div class="info-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email', $deputado->email) }}">
        </div>

        <div class="info-group">
            <label for="nome_civil">Nome Civil:</label>
            <input type="text" name="nome_civil" id="nome_civil" value="{{ old('nome_civil', $deputado->nome_civil) }}">
        </div>

        <div class="info-group">
            <label for="escolaridade">Escolaridade:</label>
            <input type="text" name="escolaridade" id="escolaridade" value="{{ old('escolaridade', $deputado->escolaridade) }}">
        </div>

        <div class="info-group">
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" name="data_nascimento" id="data_nascimento" value="{{ old('data_nascimento', $deputado->data_nascimento) }}">
        </div>

        <div class="info-group">
            <label for="partido">Partido:</label>
            <input type="text" name="partido" id="partido" value="{{ old('partido', $deputado->partido) }}">
        </div>

        <div class="info-group">
            <label for="naturalidade">Naturalidade:</label>
            <input type="text" name="naturalidade" id="naturalidade" value="{{ old('naturalidade', $deputado->naturalidade) }}">
        </div>

        <button type="submit">Salvar Alterações</button>
    </form>

    <div class="back-button">
        <a href="{{ url()->previous() }}">← Voltar</a>
    </div>
</div>
@endsection
