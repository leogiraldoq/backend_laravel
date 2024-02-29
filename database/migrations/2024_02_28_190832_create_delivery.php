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
        Schema::create('delivery', function (Blueprint $table) {
            $table->id('id_delivery');
            $table->string('names');
            
            $table->bigInteger('pickup_id')->unsigned()->index();
            $table->foreign('pickup_id')->on('pick_up_company')->references('id_pick_up_company');
            
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->on('users')->references('id_user');
            
            $table->longText('photo');
            $table->longText('signature');
            $table->longText('ticket');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery');
    }
};
