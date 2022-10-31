<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetugasOpnamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petugas_opnames', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('opname_id');
            $table->foreign('opname_id')
            ->references('id')->on('opnames');
            $table->unsignedBigInteger('petugas_id');
            $table->foreign('petugas_id')
            ->references('id')->on('users');
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
        Schema::dropIfExists('petugas_opnames');
    }
}
