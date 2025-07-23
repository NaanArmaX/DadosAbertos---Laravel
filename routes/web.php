<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeputadoController;
use App\Http\Controllers\DeputadoFicController;
use App\Http\Controllers\NewsController;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


Route::get('/buscar-deputados', [DeputadoController::class, 'buscar'])->name('buscarDeputados');
Route::get('/deputados/{id}', [DeputadoController::class, 'show'])->name('deputados.show');
Route::get('/deputados', [DeputadoController::class, 'index'])->name('deputados.index');

Route::get('/criar', [DeputadoFicController::class, 'criar'])->name('deputadosfic.teste');
Route::post('/salvar', [DeputadoFicController::class, 'create'])->name('deputadosfic.salvar');

Route::get('/deputados-fic/{id}', [DeputadoFicController::class, 'show'])->name('deputadosfic.show');
Route::get('/deputados-fic/{id}/edit', [DeputadoFicController::class, 'edit'])->name('deputadosfic.edit');
Route::put('/deputados-fic/{id}', [DeputadoFicController::class, 'update'])->name('deputadosfic.update');
Route::delete('/deputados-fic/{id}', [DeputadoFicController::class, 'destroy'])->name('deputadosfic.destroy');

Route::get('/partidos', [DeputadoController::class, 'listarPartidos'])->name('partidos.index');
Route::get('/partidos/{partido}/deputados', [DeputadoController::class, 'deputadosPorPartido'])->name('partidos.deputados');

Route::get('/noticias', [NewsController::class, 'getNews']);

Route::post('/newsletter/subscribe', [NewsController::class, 'sendNewsletter'])->name('newsletter.subscribe');
Route::get('/newsletter/send', [NewsController::class, 'sendNewsletter']);

Route::get('deputados/criar', [DeputadoController::class, 'criar'])->name('deputados.criar');




