<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemPrevendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_prevendas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_prevenda')->unsigned();
            $table->foreign('id_prevenda')->references('id')->on('prevendas');
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
        Schema::dropIfExists('item_prevendas');
    }
}
