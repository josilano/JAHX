<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_vendas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_venda')->unsigned();
            $table->foreign('id_venda')->references('id')->on('vendas');
            //$table->integer('id_produto')->unsigned();
            //$table->foreign('id_produto')->references('id')->on('produtos');//vai sair
            $table->string('descricao_produto');
            $table->string('ean_produto');
            $table->string('un_produto');
            $table->integer('qtd_venda');
            $table->double('preco_vendido', 8, 2);
            $table->double('subtotal', 8, 2);
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
        Schema::dropIfExists('item_vendas');
    }
}
