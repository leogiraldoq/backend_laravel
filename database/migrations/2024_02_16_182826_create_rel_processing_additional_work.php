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
        Schema::create('rel_pro_work', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('process_id')->unsigned()->index();
            $table->foreign('process_id')->references('id_process')->on('processing');
            
            $table->bigInteger('add_work_id')->unsigned()->index();
            $table->foreign('add_work_id')->references('id_add_work')->on('process_add_work');
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_pro_work');
    }
};
