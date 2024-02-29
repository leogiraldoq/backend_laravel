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
        Schema::create('packing', function (Blueprint $table) {
            $table->id('id_pack');
            
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->on('users')->references('id_user');
            
            $table->bigInteger('customer_id')->unsigned()->index();
            $table->foreign('customer_id')->on('costumers')->references('id_costumer');
            
            $table->bigInteger('boutique_id')->unsigned()->index();
            $table->foreign('boutique_id')->on('boutiques')->references('id_boutique');
                        
            $table->bigInteger('box_id')->unsigned()->index();
            $table->foreign('box_id')->on('boxes')->references('id_box');
            
            $table->double('weight');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packing');
    }
};
