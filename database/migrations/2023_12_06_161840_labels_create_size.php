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
        Schema::create('labels_create_size',function(Blueprint $table){
           $table->id('id_label_size');
           $table->string('title_label_size')->unique()->required();
           $table->json('list_size')->comment('Array for sizes');
           $table->boolean('active')->default(true);
           $table->timestamps();
        });
            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labels_create_size');
    }
};
