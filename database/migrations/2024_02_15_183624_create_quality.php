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
        Schema::create('quality', function (Blueprint $table) {
            $table->id('id_quality');
            
            $table->bigInteger('process_id')->unsigned()->index();
            $table->foreign('process_id')->references('id_process')->on('processing');
            
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quality');
    }
};
