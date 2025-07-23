@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Crie um Deputado</h2>

        <form action="{{ route('deputadosfic.salvar') }}" method="POST">
            @csrf
            <div class="card shadow-lg p-4">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" required placeholder="Nome do Deputado">
                </div>

                <div class="form-group">
                    <label for="partido">Partido:</label>
                    <select class="form-control" id="partido" name="partido" required>
                        <option value="" disabled selected>Selecione o Partido</option>
                        @foreach($partidos as $partido)
                            <option value="{{ $partido->partido }}">{{ $partido->partido }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="naturalidade">Naturalidade:</label>
                    <select class="form-control" id="naturalidade" name="naturalidade" required>
                        <option value="" disabled selected>Selecione a Naturalidade</option>
                        @foreach($naturalidades as $sigla => $estado)
                            <option value="{{ $sigla }}">{{ $estado }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="E-mail do Deputado">
                </div>

                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento:</label>
                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento">
                </div>

                <div class="form-group">
                    <label for="escolaridade">Escolaridade:</label>
                    <input type="text" class="form-control" id="escolaridade" name="escolaridade" placeholder="Escolaridade do Deputado">
                </div>

               <div class="form-group">
                    <label for="legislatura">Legislatura:</label>
                    <select class="form-control" id="legislatura" name="legislatura" required>
                        <option value="" disabled selected>Selecione a Legislatura</option>
                        <option value="atual">Atual</option>
                        <option value="passada">Passada</option>
                    </select>
                </div>

                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">Salvar Deputado</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <style>
        /* Customização minimalista e moderna */
        .container {
            max-width: 600px;
            padding: 20px;
        }

        h2 {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            font-weight: 600;
        }

        .card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .card .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 14px;
            color: #555;
            font-weight: 500;
        }

        .form-control {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            font-size: 16px;
            color: #333;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
            outline: none;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-primary:focus {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        /* Mobile responsiveness */
        @media (max-width: 576px) {
            .container {
                padding: 15px;
            }

            .card {
                padding: 20px;
            }

            .btn-primary {
                width: 100%;
            }
        }
    </style>
@endpush
