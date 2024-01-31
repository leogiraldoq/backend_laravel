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
        Schema::create('labels_create_content',function(Blueprint $table){
           $table->id('id_label_content');
           $table->string('title_content');
           $table->json('list_contents')->comment('Array of objects content the strings taht we will impress');
           $table->boolean('active')->default(true);
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labels_create_content');
    }
};
