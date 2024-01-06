<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveQtdVendaToItemPrevendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_prevendas', function (Blueprint $table) {
            $table->dropColumn('qtd_venda');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_prevendas', function (Blueprint $table) {
            $table->integer('qtd_venda')->after('un_produto');
        });
    }
}
