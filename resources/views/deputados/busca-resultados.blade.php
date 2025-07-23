@extends('layouts.app')

@push('styles')
<style>
    /* Container da lista */
    .deputado-lista {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 20px;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
        padding: 0 10px;
    }

    /* Card do deputado */
    .deputado-card {
        background-color: #ffffff;
        border: 1px solid #d1d5db; /* cinza claro */
        padding: 18px 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(33, 150, 83, 0.1);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
    }

    .deputado-card:hover {
        background-color: #e6f4ea; /* leve verde */
        box-shadow: 0 4px 15px rgba(33, 150, 83, 0.3);
    }

    /* Link do deputado */
    .deputado-card a {
        text-decoration: none;
        color: #166534; /* verde escuro */
        font-weight: 600;
        font-size: 1.1rem;
        flex-grow: 1;
        transition: color 0.3s ease;
    }

    .deputado-card a:hover {
        color: #34d399; /* verde mais claro */
        text-decoration: underline;
    }

    /* Mensagem quando não encontrar deputados */
    p {
        text-align: center;
        font-size: 1.1rem;
        color: #6b7280; /* cinza médio */
        margin-top: 40px;
    }
</style>
@endpush

@section('content')
    <h1 style="text-align:center; margin-bottom: 25px; color: #166534;">Deputados encontrados</h1>

    @if(count($deputados) > 0)
        <div class="deputado-lista">
            @foreach($deputados as $dep)
                <div class="deputado-card">
                    <a href="{{ route('deputados.show', $dep->id) }}">
                        {{ $dep->nome }} ({{ $dep->partido }} - {{ $dep->uf }})
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <p>Nenhum deputado encontrado com esse nome.</p>
    @endif
@endsection
