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
        Schema::create('boutiques', function (Blueprint $table) {
            $table->id('id_boutique');
            
            //Foreign key costumer table
            $table->bigInteger('costumer_id')->unsigned()->index();
            $table->foreign('costumer_id')->references('id_costumer')->on('costumers')->onUpdate('cascade');

            $table->string('name')->require();
            $table->string('address')->require();
            $table->string('city')->require();
            $table->string('final_destination')->require();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boutiques');
    }
};
