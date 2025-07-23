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

        /* Formatação do botão de inscrever-se */
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

        /* Estilo do input do email */
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

    </style>
@endpush

@section('content')
<div class="deputado-container">
    <div class="deputado-header">
        @if($deputado->foto)
            <img src="{{ $deputado->foto }}" alt="Foto de {{ $deputado->nome }}" class="deputado-photo">
        @endif
        <h2>{{ $deputado->nome }}</h2>
        <button id="openModalBtn">Quer receber noticias desse deputado?</button>
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

    <!-- Modal para Newsletter -->
    <div id="newsletterModal" class="modal">
        <div class="modal-content">
            <span id="closeModalBtn" class="close">&times;</span>
            <h2>Inscreva-se na nossa newsletter</h2>
            <form action="{{ route('newsletter.subscribe') }}" method="POST">
                @csrf
                <input type="email" name="email" placeholder="Digite seu e-mail" required>
                <button type="submit">Inscrever-se</button>
            </form>
        </div>
    </div>

    <!-- Exibindo as despesas -->
    @if(is_array($despesas) && count($despesas) > 0)
    <h3>Despesas do Deputado:</h3>
    <table class="despesa-table">
        <thead>
            <tr>
                <th>Data</th>
                <th>Tipo de Despesa</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($despesas as $despesa)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($despesa['dataDocumento'])->format('d/m/Y') }}</td>
                    <td>{{ $despesa['tipoDespesa'] }}</td>
                    <td>R$ {{ number_format($despesa['valorDocumento'], 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p>Este deputado não possui despesas registradas.</p>
    @endif

    <div class="back-button">
        <a href="{{ url()->previous() }}">← Voltar</a>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var modal = document.getElementById("newsletterModal");
        var openModalBtn = document.getElementById("openModalBtn");
        var closeModalBtn = document.getElementById("closeModalBtn");

        openModalBtn.onclick = function () {
            modal.style.display = "block";
            modal.querySelector(".modal-content").style.transform = "translateY(0)";
        }

        closeModalBtn.onclick = function () {
            modal.style.display = "none";
            modal.querySelector(".modal-content").style.transform = "translateY(-50px)";
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
                modal.querySelector(".modal-content").style.transform = "translateY(-50px)";
            }
        }
    });
</script>

@endsection
