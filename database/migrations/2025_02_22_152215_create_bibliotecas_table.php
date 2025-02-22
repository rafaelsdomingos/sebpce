<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bibliotecas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('macroregiao_id')->constrained('macroregiaos')->cascadeOnDelete();
            $table->string('tipo');
            $table->string('nome');
            $table->string('endereco')->nullable();
            $table->string('cep')->nullable();
            $table->string('cidade')->nullable();
            $table->string('fone')->nullable();
            $table->string('celular')->nullable();
            $table->string('email')->nullable();
            $table->string('horario_funcionamento')->nullable();
            $table->date('data_criacao')->nullable();
            $table->boolean('possui_lei')->nullable();
            $table->string('lei_criacao')->nullable();
            $table->string('subordinacao')->nullable();
            $table->boolean('foi_implantada')->nullable();
            $table->date('data_implantacao')->nullable();
            $table->boolean('foi_modernizada')->nullable();
            $table->date('data_modernizacao')->nullable();
            $table->boolean('orcamento_proprio')->nullable();
            $table->string('registro_sebp')->nullable();
            $table->json('servicos_prestados')->nullable();
            $table->json('redes_sociais')->nullable();
            //Editais
            $table->json('editais')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bibliotecas');
    }
};
