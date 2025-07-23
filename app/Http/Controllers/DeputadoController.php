<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\Deputado;
use Illuminate\Http\Request;
use App\Models\DeputadoFic;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class DeputadoController extends Controller
{
public function index(Request $request)
{
    // Consultas com campo 'origem'
    $queryDeputados = Deputado::select('id', 'nome', 'uf', 'partido', \DB::raw("'deputados' as origem"));

    if ($request->filled('partido')) {
        $queryDeputados->where('partido', $request->partido);
    }

    if ($request->filled('uf')) {
        $queryDeputados->where('uf', $request->uf);
    }

    if ($request->filled('ordem')) {
        $order = $request->ordem === 'desc' ? 'desc' : 'asc';
        $queryDeputados->orderBy('nome', $order);
    } else {
        $queryDeputados->orderBy('nome', 'asc');
    }

    $queryDeputadosFic = DeputadoFic::select('id', 'nome', 'naturalidade as uf', 'partido', \DB::raw("'deputadosfic' as origem"));

    if ($request->filled('partido')) {
        $queryDeputadosFic->where('partido', $request->partido);
    }

    if ($request->filled('uf')) { // aqui você pode filtrar naturalidade usando uf também se quiser
        $queryDeputadosFic->where('naturalidade', $request->uf);
    }

    if ($request->filled('ordem')) {
        $order = $request->ordem === 'desc' ? 'desc' : 'asc';
        $queryDeputadosFic->orderBy('nome', $order);
    } else {
        $queryDeputadosFic->orderBy('nome', 'asc');
    }

    // Busca os resultados das duas consultas
    $deputados = $queryDeputados->get();
    $deputadosFic = $queryDeputadosFic->get();

    // Une as collections
    $todosDeputados = $deputados->concat($deputadosFic);

    // Ordena a coleção toda por nome (opcional)
    $todosDeputados = $todosDeputados->sortBy('nome')->values();

    // Paginação manual
    $perPage = 20;
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $currentResults = $todosDeputados->slice(($currentPage - 1) * $perPage, $perPage)->values();

    $paginatedDeputados = new LengthAwarePaginator(
        $currentResults,
        $todosDeputados->count(),
        $perPage,
        $currentPage,
        ['path' => LengthAwarePaginator::resolveCurrentPath()]
    );

    // Para filtros
    $partidos = Deputado::select('partido')->distinct()->orderBy('partido')->pluck('partido');
    $ufs = Deputado::select('uf')->distinct()->orderBy('uf')->pluck('uf');

    return view('deputados.index', [
        'deputados' => $paginatedDeputados,
        'partidos' => $partidos,
        'ufs' => $ufs
    ]);
}

 

public function listarPartidos(Request $request)
{
    
    $queryDeputados = Deputado::select('partido');
    if ($request->filled('uf')) {
        $queryDeputados->where('uf', $request->uf);
    }

    // Filtra deputados fictícios
    $queryDeputadosFic = DeputadoFic::select('partido');
    if ($request->filled('naturalidade')) {
        $queryDeputadosFic->where('naturalidade', $request->uf);
    }

    
    $unionQuery = $queryDeputados->union($queryDeputadosFic);

    // Subquery com distinct e paginação correta
    $partidos = DB::table(DB::raw("({$unionQuery->toSql()}) as sub"))
        ->mergeBindings($unionQuery->getQuery())
        ->select('partido')
        ->distinct()
        ->orderBy('partido')
        ->paginate(20);


    
     $ufs = Deputado::select('uf')->distinct()->orderBy('uf')->pluck('uf');

     return view('partidos.index', compact('partidos', 'ufs'));
}

public function deputadosPorPartido($partido)
{
    // Recupera todos os deputados daquele partido
    $deputados = Deputado::where('partido', $partido)->paginate(20);

    $deputadosFic = DeputadoFic::where('partido', $partido)->paginate(20);
    
    $deputados = $deputados->merge($deputadosFic);

    $ufs = Deputado::select('uf')->distinct()->orderBy('uf')->pluck('uf');

    return view('deputados.deputado-partido', compact('deputados', 'ufs', 'partido'));
}

    public function buscar(Request $request) 
    {
    $termo = $request->input('q');

    $deputados = Deputado::where('nome', 'like', "%{$termo}%")
                  ->orWhere('uf', 'like', "%{$termo}%")
                  ->orWhere('partido', 'like', "%{$termo}%")
                  ->select('id', 'nome', 'uf', 'partido')
                  ->get();

    $deputadosFic = DeputadoFic::where('nome', 'like', "%{$termo}%")

        ->orWhere('naturalidade', 'like', "%{$termo}%")
        ->orWhere('partido', 'like', "%{$termo}%")
        ->select('id', 'nome', 'naturalidade', 'partido')
        ->get();

    $deputados = $deputados->merge($deputadosFic);

    return response()->json($deputados);
    }

public function show($id)
{
    // Busca pelo id interno do banco
    $deputado = Deputado::findOrFail($id);

    $idExterno = $deputado->id_externo;

    $response = Http::get("https://dadosabertos.camara.leg.br/api/v2/deputados/{$idExterno}/despesas");



    $despesas = [];
    if ($response->successful()) {
        $json = $response->json();
        $despesas = $json['dados'] ?? [];
    }

    $responseDetalhes = Http::get("https://dadosabertos.camara.leg.br/api/v2/deputados/{$idExterno}");
    $email = null;
    $nomeCivil = null;
    $foto = null;
    $escolaridade = null;
    $nascimento = null;
    $naturalidade = null;

if ($responseDetalhes->successful()) {
    $dados = $responseDetalhes->json()['dados'];

    $email = $dados['ultimoStatus']['gabinete']['email'] ?? null;
    $nomeCivil = $dados['nomeCivil'] ?? null;
    $foto = $dados['ultimoStatus']['urlFoto'] ?? null;
    $escolaridade = $dados['escolaridade'] ?? null;
    $nascimento = $dados['dataNascimento'] ?? null;
    $naturalidade = $dados['municipioNascimento'] . ' - ' . $dados['ufNascimento'];
}

    return view('deputados.show', compact(
    'deputado', 'despesas', 'email', 'nomeCivil', 'foto', 'escolaridade', 'nascimento', 'naturalidade'
));
}

public function buscaResultados(Request $request)
{
    $q = $request->query('q', '');

    $deputados = Deputado::where('nome', 'LIKE', "%{$q}%")->get();

    $deputadosFic = DeputadoFic::where('nome', 'LIKE', "%{$q}%")->get();
    
    $deputados = $deputados->merge($deputadosFic);

    return view('deputados.busca-resultados', compact('deputados', 'q'));
}

}
