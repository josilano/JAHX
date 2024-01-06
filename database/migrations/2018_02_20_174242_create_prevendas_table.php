<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrevendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prevendas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cliente')->unsigned();
            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->double('total_itens', 8, 2);
            $table->string('tipo_desconto', 10)->nullable();
            $table->string('desconto', 10)->nullable();
            $table->double('total_venda', 8, 2);
            $table->string('forma_pg_venda', 50)->nullable();
            $table->string('parcelas', 2)->nullable();
            $table->enum('status', ['baixada', 'aberta', 'pendente']);
            $table->double('dinheiro', 8, 2);
            $table->double('troco', 8, 2);
            $table->string('observacoes')->nullable();
            $table->enum('setor_venda',['erp', 'pdv']);
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
        Schema::dropIfExists('prevendas');
    }
}
