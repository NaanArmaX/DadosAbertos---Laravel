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

        .deputado-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #4caf50;
            margin-bottom: 15px;
        }

        .info-group {
            margin-bottom: 15px;
        }

        .info-label {
            font-weight: bold;
            color: #333;
        }

        .back-button {
            margin-top: 30px;
            text-align: center;
        }

        .back-button a {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 25px;
        }

        .despesa-table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        .despesa-table th, .despesa-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .despesa-table th {
            background-color: #f4f4f4;
        }

        /* Estilos gerais para o modal */
        .modal {
            display: none; /* O modal está oculto por padrão */
            position: fixed; /* Fixa o modal na tela */
            z-index: 1000; /* Coloca o modal acima de outros elementos */
            left: 0;
            top: 0;
            width: 100%; /* Largura total */
            height: 100%; /* Altura total */
            background-color: rgba(0, 0, 0, 0.5); /* Fundo semitransparente */
            transition: opacity 0.3s ease;
        }

        /* O conteúdo do modal (caixa central) */
        .modal-content {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            margin: 10% auto; /* Centraliza o modal na tela */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: translateY(-50px);
            transition: transform 0.3s ease;
        }

        .modal-content h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        /* O botão de fechar (X) */
        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
        }

        /* Botões */
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 25px;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        input[type="email"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 25px;
            border: 1px solid #ddd;
            font-size: 16px;
            box-sizing: border-box;
        }

        /* Botão de abrir o modal */
        #openModalBtn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        #openModalBtn:hover {
            background-color: #218838;
        }

        /* Estilo dos botões do Modal de Exclusão */
        .btn-danger {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-editar {
    background-color: #28a745; /* Verde */
    color: #fff;
    padding: 10px 25px;
    border-radius: 25px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    font-size: 16px;
    transition: background-color 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.btn-editar:hover {
    background-color: #218838;
}

.btn-apagar {
    background-color: #e74c3c; /* Vermelho */
    color: #fff;
    padding: 10px 25px;
    border-radius: 25px;
    border: none;
    cursor: pointer;
    width: 20%;
    font-weight: 600;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.btn-apagar:hover {
    background-color: #c0392b;
}

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-confirm {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-confirm:hover {
            background-color: #27ae60;
        }

    </style>
@endpush

@section('content')
<div class="deputado-container">
    <div class="deputado-header">
        @if($deputado->foto)
            <img src="{{ $deputado->foto }}" alt="Foto de {{ $deputado->nome }}" class="deputado-photo">
        @endif
        <h2>{{ $deputado->nome }}</h2>
        <h2>Deputado Fictício:</h2>
        
        <a href="{{ route('deputadosfic.edit', $deputado->id) }}" class="btn-editar">Editar</a>
        
        <!-- Botão de excluir -->
        <button id="openDeleteModalBtn" class="btn-apagar">Apagar</button>
    </div>

    <div class="info-group">
        <span class="info-label">Nome Civil:</span> {{ $nomeCivil }}
    </div>

    <div class="info-group">
        <span class="info-label">Email:</span> {{ $email ?? 'Não informado' }}
    </div>

    <div class="info-group">
        <span class="info-label">Nascimento:</span> {{ \Carbon\Carbon::parse($nascimento)->format('d/m/Y') }}
    </div>

    <div class="info-group">
        <span class="info-label">Naturalidade:</span> {{ $naturalidade }}
    </div>

    <div class="info-group">
        <span class="info-label">Escolaridade:</span> {{ $escolaridade }}
    </div>

    <div class="info-group">
        <span class="info-label">Legislatura:</span> {{ $deputado->legislatura ?? 'Atual' }}
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span id="closeModalBtn" class="close">&times;</span>
            <h2>Tem certeza que deseja excluir este deputado fictício?</h2>
            <form action="{{ route('deputadosfic.destroy', $deputado->id) }}" method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <button type="button" class="btn-confirm" onclick="document.getElementById('deleteForm').submit()">Confirmar Exclusão</button>
                <button type="button" id="cancelDeleteBtn" class="btn-danger">Cancelar</button>
            </form>
        </div>
    </div>

    <div class="back-button">
        <a href="{{ url()->previous() }}">← Voltar</a>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var modal = document.getElementById("deleteModal");
        var openDeleteModalBtn = document.getElementById("openDeleteModalBtn");
        var closeModalBtn = document.getElementById("closeModalBtn");
        var cancelDeleteBtn = document.getElementById("cancelDeleteBtn");

        // Exibe o modal ao clicar no botão "Apagar"
        openDeleteModalBtn.onclick = function () {
            modal.style.display = "block";
        }

        // Fecha o modal ao clicar no "X"
        closeModalBtn.onclick = function () {
            modal.style.display = "none";
        }

        // Fecha o modal ao clicar em "Cancelar"
        cancelDeleteBtn.onclick = function () {
            modal.style.display = "none";
        }

        // Fecha o modal ao clicar fora dele
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    });
</script>

@endsection
