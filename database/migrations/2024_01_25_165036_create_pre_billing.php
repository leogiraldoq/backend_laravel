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
        Schema::create('pre_billing', function (Blueprint $table) {
            $table->id('id_pre_bill');
            
            $table->bigInteger('receive_details_id')->unsigned()->index();
            $table->foreign('receive_details_id')->references('id_receive_detail')->on('receive_details');
            
            $table->bigInteger('invoice_number');
            $table->integer('quantity_styles')->nullable();
            $table->integer('total_pieces');
            $table->longText("photo_invoice")->nullable();
            
            $table->bigInteger("user_id")->unsigned()->index();
            $table->foreign("user_id")->references("id_user")->on("users");
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_billing');
    }
};
