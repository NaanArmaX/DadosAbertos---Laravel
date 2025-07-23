<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeputadosTable extends Migration
{
    public function up()
    {
        Schema::create('deputados', function (Blueprint $table) {
            $table->id(); 
            $table->string('id_externo')->unique(); 
            $table->string('nome');
            $table->string('partido');
            $table->string('uf', 2); 
            $table->string('foto')->nullable(); 
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('deputados');
    }
}
