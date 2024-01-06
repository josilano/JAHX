<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero_nota', 80);
            $table->integer('id_fornecedor')->unsigned();
            $table->foreign('id_fornecedor')->references('id')->on('fornecedores');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->date('data_emissao')->nullable();
            $table->double('total_compra', 8, 2);
            $table->string('forma_pg_compra', 50)->nullable();
            $table->string('parcelas', 2)->nullable();
            $table->enum('status', ['finalizada', 'cancelada', 'pendente']);
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
        Schema::dropIfExists('compras');
    }
}
