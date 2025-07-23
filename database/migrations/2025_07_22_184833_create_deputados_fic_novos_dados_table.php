<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeputadosFicNovosDadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deputados_fic', function (Blueprint $table) {
            $table->id();  
            $table->string('nome');  
            $table->string('partido');  
            $table->string('naturalidade');  
            $table->string('foto')->nullable();  
            $table->string('email')->unique()->nullable();  
            $table->date('data_nascimento')->nullable();  
            $table->string('escolaridade')->nullable();  
            $table->string('legislatura')->nullable();  
            $table->timestamps();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deputados_fic_novos_dados');
    }
}
