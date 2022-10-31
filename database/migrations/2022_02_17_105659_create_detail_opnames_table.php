<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailOpnamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_opnames', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('opname_id');
            $table->foreign('opname_id')
            ->references('id')->on('opnames');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
            ->references('id')->on('products');
            $table->integer('seharusnya');
            $table->integer('fisik');
            $table->decimal('selisih',8,0);
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('detail_opnames');
    }
}
