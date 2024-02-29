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
        Schema::create('rel_pack_delivery', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('packing_id')->unsigned()->index();
            $table->foreign('packing_id')->on('packing')->references('id_pack');
            
            $table->bigInteger('delivery_id')->unsigned()->index();
            $table->foreign('delivery_id')->on('delivery')->references('id_delivery');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_pack_delivery');
    }
};
