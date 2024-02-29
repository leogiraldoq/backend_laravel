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
        Schema::create('rel_pack_stores', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('pack_id')->unsigned()->index();
            $table->foreign('pack_id')->on('packing')->references('id_pack');
            
            $table->bigInteger('receive_details_id')->unsigned()->index();
            $table->foreign('receive_details_id')->on('receive_details')->references('id_receive_detail');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_pack_stores');
    }
};
