@extends('layouts.app')

@push('styles')
<style>
    .container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 15px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
    }

    h1 {
        text-align: center;
        color: #166534;
        margin-bottom: 30px;
        font-weight: 700;
        font-size: 2.2rem;
    }

    form.mb-4 {
        background: #f3f9f5;
        border: 1px solid #d1e7d0;
        padding: 20px 25px;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(22, 101, 52, 0.1);
    }

    form.mb-4 > div {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: center;
        justify-content: center;
    }

    form.mb-4 label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        color: #2d6a2d;
        font-size: 0.9rem;
    }

    form.mb-4 select {
        min-width: 140px;
        padding: 8px 12px;
        border: 1.5px solid #a6d1a1;
        border-radius: 6px;
        font-size: 1rem;
        background: white;
        transition: border-color 0.3s ease;
        cursor: pointer;
    }

    form.mb-4 select:hover, form.mb-4 select:focus {
        border-color: #4caf50;
        outline: none;
    }

    form.mb-4 button {
        background-color: #4caf50;
        color: white;
        border: none;
        padding: 10px 25px;
        font-weight: 700;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }

    form.mb-4 button:hover {
        background-color: #3a9a38;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        font-size: 1rem;
        box-shadow: 0 3px 8px rgba(22, 101, 52, 0.1);
        border-radius: 12px;
        overflow: hidden;
    }

    thead {
        background-color: #4caf50;
        color: white;
    }

    thead th {
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
    }

    tbody tr {
        border-bottom: 1px solid #e3e3e3;
        transition: background-color 0.2s ease;
        cursor: pointer;
    }

    tbody tr:hover {
        background-color: #e6f4ea;
    }

    tbody td {
        padding: 12px 15px;
        color: #2d6a2d;
    }

    tbody td a {
        color: #166534;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    tbody td a:hover {
        color: #34d399;
        text-decoration: underline;
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    tbody tr td[colspan="3"] {
        text-align: center;
        font-style: italic;
        color: #888;
        padding: 30px 0;
    }

    /* Paginação refinada */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    margin-top: 30px;
    gap: 8px;
    font-size: 0.95rem;
}

.pagination li {
    list-style: none;
}

.pagination li a,
.pagination li span {
    display: inline-block;
    padding: 8px 14px;
    color: #166534;
    background-color: #f8fff7;
    border: 1.5px solid #a6d1a1;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    transition: background-color 0.3s ease, color 0.3s ease;
    min-width: 40px;
    text-align: center;
}

.pagination li a:hover {
    background-color: #4caf50;
    color: white;
    border-color: #4caf50;
}

.pagination .active span {
    background-color: #4caf50;
    color: white;
    border-color: #4caf50;
}

.pagination li.disabled span {
    color: #aaa;
    background-color: #f0f0f0;
    border-color: #ddd;
    cursor: not-allowed;
}

</style>
@endpush

@section('content')
    <div class="container">
        <h1>Lista de Deputados</h1>

        <!-- Filtros -->
        <form method="GET" action="{{ route('deputados.index') }}" class="mb-4">
            <div>
                <div>
                    <label for="partido">Partido:</label>
                    <select name="partido" id="partido">
                        <option value="">Todos</option>
                        @foreach($partidos as $partido)
                            <option value="{{ $partido }}" {{ request('partido') == $partido ? 'selected' : '' }}>
                                {{ $partido }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="uf">UF:</label>
                    <select name="uf" id="uf">
                        <option value="">Todos</option>
                        @foreach($ufs as $uf)
                            <option value="{{ $uf }}" {{ request('uf') == $uf ? 'selected' : '' }}>
                                {{ $uf }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="ordem">Ordenar por nome:</label>
                    <select name="ordem" id="ordem">
                        <option value="asc" {{ request('ordem') == 'asc' ? 'selected' : '' }}>A-Z</option>
                        <option value="desc" {{ request('ordem') == 'desc' ? 'selected' : '' }}>Z-A</option>
                    </select>
                </div>

                <div>
                    <button type="submit">Filtrar</button>
                </div>
            </div>
        </form>

        <!-- Lista de deputados -->
      <table>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Partido</th>
            <th>UF</th>
        </tr>
    </thead>
    <tbody>
@foreach($deputados as $dep)
    @php
        $rota = $dep->origem === 'deputadosfic'
            ? route('deputadosfic.show', $dep->id)
            : route('deputados.show', $dep->id);
    @endphp
    <tr onclick="window.location='{{ $rota }}'">
        <td><a href="{{ $rota }}">{{ $dep->nome }}</a></td>
        <td>{{ $dep->partido }}</td>
        <td>{{ $dep->uf }}</td>
    </tr>
@endforeach

@if($deputados->isEmpty())
    <tr>
        <td colspan="3" class="text-center">Nenhum deputado encontrado.</td>
    </tr>
@endif
</tbody>
</table>

        <!-- Paginação -->
        <div class="pagination">
            {{ $deputados->links('vendor.pagination.custom') }}
        </div>
    </div>
@endsection
