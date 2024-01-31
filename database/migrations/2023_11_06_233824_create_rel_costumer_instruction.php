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
        Schema::create('rel_costumer_instruction', function (Blueprint $table) {
            $table->id();
            
            //Foreign key costumers table
            $table->bigInteger('costumer_id')->unsigned()->index();
            $table->foreign('costumer_id')->references('id_costumer')->on('costumers');
            
            //Object contains the instructions and image for example
            $table->json('instructions')->comments('Object whit the instrucctions to production and image example');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_costumer_instruction');
    }
};
