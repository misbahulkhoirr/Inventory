<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moves', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
            ->references('id')->on('products');
            $table->unsignedBigInteger('dari_gudang');
            $table->foreign('dari_gudang')
            ->references('id')->on('gudangs');
            $table->unsignedBigInteger('ke_gudang');
            $table->foreign('ke_gudang')
            ->references('id')->on('gudangs');
            $table->decimal('amount',8,0);
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
        Schema::dropIfExists('moves');
    }
}
