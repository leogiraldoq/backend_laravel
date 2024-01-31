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
        Schema::create('receive', function (Blueprint $table) {
            $table->id('id_receive');
            $table->bigInteger('follow_number');
            
            //Foreing key to users
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id_user')->on('users');
            
            //Foreing Key to shippers
            $table->bigInteger('shipper_id')->unsigned()->index();
            $table->foreign('shipper_id')->references('id_shipper')->on('shippers');

            //Foreing Key to customers
            $table->bigInteger('customer_id')->unsigned()->index();
            $table->foreign('customer_id')->references('id_costumer')->on('costumers');
            
            $table->longText('observations')->nullable();
            $table->longText('photo')->comments('Photo for the person to bring the boxes');
            $table->string('its_process');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receive');
    }
};
