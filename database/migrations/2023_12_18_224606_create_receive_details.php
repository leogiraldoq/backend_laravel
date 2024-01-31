<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('receive_details', function (Blueprint $table) {
            $table->id('id_receive_detail');
            
            //Foreing key to receive
            $table->bigInteger('receive_id')->unsigned()->index();
            $table->foreign('receive_id')->references('id_receive')->on('receive');
            
            //Foreing key customer boutique
            $table->bigInteger('boutique_id')->unsigned()->index();
            $table->foreign('boutique_id')->references('id_boutique')->on('boutiques');
            
            //Foreing Key boxes
            $table->bigInteger('box_id')->unsigned()->index();
            $table->foreign('box_id')->references('id_box')->on('boxes');
            
            $table->integer('quantity_box');
            $table->double('weight_box');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receive_details');
    }
};
