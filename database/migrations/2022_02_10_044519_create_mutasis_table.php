<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMutasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('list_mutasi_id')->nullable();
            $table->foreign('list_mutasi_id')
            ->references('id')->on('list_mutasis');
            $table->unsignedBigInteger('gudang_id');
            $table->foreign('gudang_id')
            ->references('id')->on('gudangs');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
            ->references('id')->on('products');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
            ->references('id')->on('users');
            $table->enum('mutasi',['In','Out']);
            $table->integer('jumlah');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')
            ->references('id')->on('suppliers');
            $table->integer('balance');
            $table->boolean('balancing')->default(false);
            $table->text('keterangan')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('mutasis');
    }
}
