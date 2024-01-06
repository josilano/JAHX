<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQtdCompraToItemComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_compras', function (Blueprint $table) {
            $table->double('qtd_compra', 9, 3)->after('id_produto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_compras', function (Blueprint $table) {
            $table->dropColumn('qtd_compra');
        });
    }
}
