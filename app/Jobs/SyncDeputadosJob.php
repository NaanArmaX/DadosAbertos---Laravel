<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\Deputado;

class SyncDeputadosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $itensPorPagina = 50;

   public function handle(): void
{
    $pagina = Cache::get('sync_deputados_pagina', 1);
    $itensPorPagina = $this->itensPorPagina;

    $response = Http::get('https://dadosabertos.camara.leg.br/api/v2/deputados', [
        'pagina' => $pagina,
        'itens' => $itensPorPagina,
    ]);

    if (!$response->successful()) {
        Log::error("Erro ao acessar API dos deputados na página {$pagina}: " . $response->status());
        return;
    }

    $dados = $response->json();

    $deputados = $dados['dados'] ?? [];
    $links = $dados['links'] ?? [];

    if (empty($deputados)) {
        Log::info("Nenhum deputado encontrado na página {$pagina}. Finalizando sincronização.");
        Cache::put('sync_deputados_finalizado', true, now()->addHours(24));
        Cache::put('sync_deputados_pagina', 1);
        return;
    }

    foreach ($deputados as $dep) {
        Deputado::updateOrCreate(
            ['id_externo' => $dep['id']],
            [
                'nome' => $dep['nome'],
                'partido' => $dep['siglaPartido'],
                'uf' => $dep['siglaUf'],
                'foto' => $dep['urlFoto'] ?? null,
            ]
        );
    }

    Log::info("Página {$pagina} processada com sucesso.");

    
    $temProximaPagina = false;
    foreach ($links as $link) {
        if (($link['rel'] ?? '') === 'next') {
            $temProximaPagina = true;
            break;
        }
    }

    if ($temProximaPagina) {
        Cache::put('sync_deputados_pagina', $pagina + 1);
    } else {
        Log::info("Todas as páginas processadas. Finalizando sincronização.");
        Cache::put('sync_deputados_finalizado', true, now()->addHours(24));
        Cache::put('sync_deputados_pagina', 1);
    }
}
}
