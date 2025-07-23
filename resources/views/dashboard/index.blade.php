@extends('layouts.app')

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="charts">
    <div class="chart-box">
        <h2>Deputados por UF</h2>
        <canvas id="chartUf"></canvas>
    </div>

    <div class="chart-box">
        <h2>Deputados por Partido</h2>
        <canvas id="chartPartido"></canvas>
    </div>
</div>

<div class="table-container">
    <h2>Últimos Deputados Cadastrados</h2>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>UF</th>
                <th>Partido</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ultimosDeputados as $dep)
            <tr>
                <td>{{ $dep->nome }}</td>
                <td>{{ $dep->uf }}</td>
                <td>{{ $dep->partido }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="empty-row">Nenhum deputado encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<!-- Carregar a CDN do Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Definir os contextos dos gráficos
    const ctxUf = document.getElementById('chartUf').getContext('2d');
    const ctxPartido = document.getElementById('chartPartido').getContext('2d');

    // Verificar se há dados válidos para gráficos
    const labelsUf = {!! json_encode($porUf->keys()) !!};
    const dataUf = {!! json_encode($porUf->values()) !!};
    const labelsPartido = {!! json_encode($porPartido->keys()) !!};
    const dataPartido = {!! json_encode($porPartido->values()) !!};

    if (labelsUf.length && dataUf.length) {
        const chartUf = new Chart(ctxUf, {
            type: 'bar',
            data: {
                labels: labelsUf,
                datasets: [{
                    label: 'Deputados por UF',
                    data: dataUf,
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderRadius: 6,
                    borderWidth: 1,
                    borderColor: 'rgba(37, 99, 235, 1)',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1,
                        grid: { color: '#e5e7eb' }
                    },
                    x: {
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { labels: { font: { size: 14 } } },
                    tooltip: { enabled: true }
                }
            }
        });
    }

    if (labelsPartido.length && dataPartido.length) {
        const chartPartido = new Chart(ctxPartido, {
            type: 'bar',
            data: {
                labels: labelsPartido,
                datasets: [{
                    label: 'Deputados por Partido',
                    data: dataPartido,
                    backgroundColor: 'rgba(34, 197, 94, 0.8)',
                    borderRadius: 6,
                    borderWidth: 1,
                    borderColor: 'rgba(16, 185, 129, 1)',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1,
                        grid: { color: '#e5e7eb' }
                    },
                    x: {
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { labels: { font: { size: 14 } } },
                    tooltip: { enabled: true }
                }
            }
        });
    }
});
</script>
@endpush
