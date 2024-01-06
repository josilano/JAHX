<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQtdVendaToItemVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_vendas', function (Blueprint $table) {
            $table->double('qtd_venda', 9, 3)->after('un_produto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_vendas', function (Blueprint $table) {
            $table->dropColumn('qtd_venda');
        });
    }
}
