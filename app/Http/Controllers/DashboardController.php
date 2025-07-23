<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deputado;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDeputados = Deputado::count();

        $porUf = Deputado::select('uf', DB::raw('count(*) as total'))
            ->groupBy('uf')
            ->pluck('total', 'uf');

        $porPartido = Deputado::select('partido', DB::raw('count(*) as total'))
            ->groupBy('partido')
            ->pluck('total', 'partido');

        $ultimosDeputados = Deputado::latest()->take(5)->get();
        

        return view('dashboard.index', compact(
            'totalDeputados',
            'porUf',
            'porPartido',
            'ultimosDeputados'
        ));
    }
}
