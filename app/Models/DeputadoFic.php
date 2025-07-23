<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeputadoFic extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'deputados_fic';

    // Campos que podem ser preenchidos
    protected $fillable = [
        'nome', 
        'partido', 
        'naturalidade', 
        'foto', 
        'email', 
        'data_nascimento', 
        'escolaridade', 
        'legislatura',
    ];
}
