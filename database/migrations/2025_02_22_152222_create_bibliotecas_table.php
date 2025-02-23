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
            //Espaço Físico
            $table->decimal('extensao')->nullable();
            $table->string('predio')->nullable();
            $table->string('situacao_fisica')->nullable();
            $table->json('acessibilidade')->nullable();
            //Acervo da Biblioteca
            $table->integer('total_livros')->nullable();
            $table->string('acervo_registrado')->nullable();
            $table->string('acervo_catalogado')->nullable();
            $table->string('acervo_classificado')->nullable();
            $table->string('acervo_etiquetado')->nullable();
            $table->string('acervo_informatizado')->nullable();
            $table->string('software')->nullable();
            $table->json('acervo_acessivel')->nullable();
            $table->integer('media_emprestimo_anual')->nullable();
            $table->integer('media_emprestimo_mensal')->nullable();
            $table->json('generos_emprestados')->nullable();
            $table->integer('media_pesquisa_local')->nullable();
            $table->json('generos_pesquisados')->nullable();
            $table->json('formas_aquisicao')->nullable();
            $table->json('tipos_acervo')->nullable();
            //Equipamentos da biblioteca
            $table->integer('qtd_computadores')->nullable();
            $table->integer('qtd_impressoras')->nullable();
            $table->integer('qtd_televisores')->nullable();
            $table->integer('qtd_aparelho_dvd')->nullable();
            $table->integer('qtd_estantes')->nullable();
            $table->integer('qtd_bibliocantos')->nullable();
            $table->integer('qtd_armarios')->nullable();
            $table->integer('qtd_cadeiras')->nullable();
            $table->integer('qtd_mesas_leitores')->nullable();
            $table->integer('qtd_biros')->nullable();
            $table->integer('qtd_mesas_infantis')->nullable();
            $table->integer('qtd_cadeiras_infantis')->nullable();
            $table->integer('qtd_estantes_infantis')->nullable();
            $table->integer('qtd_puffs')->nullable();
            $table->integer('qtd_tatames_coloridos')->nullable();
            $table->integer('qtd_jogos_educativos')->nullable();
            $table->integer('qtd_quadros_aviso')->nullable();
            $table->integer('qtd_datashow')->nullable();
            $table->integer('almofadas')->nullable();
            $table->integer('bebedouro')->nullable();
            $table->integer('ventilador')->nullable();
            $table->integer('ar_condicionado')->nullable();
            $table->integer('acesso_internet')->nullable();
            $table->string('outros_equipamentos')->nullable();
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
