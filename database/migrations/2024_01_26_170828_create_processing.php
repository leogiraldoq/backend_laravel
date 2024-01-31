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
        Schema::create('processing', function (Blueprint $table) {
            $table->id("id_process");
            
            $table->bigInteger("pre_bill_id")->unsigned()->index();
            $table->foreign("pre_bill_id")->references("id_pre_bill")->on("pre_billing");
            
            $table->string("style_number");
            $table->string("style_color")->nullable();
            $table->integer("style_total");
            
            $table->bigInteger("user_id")->unsigned()->index();;
            $table->foreign("user_id")->references("id_user")->on("users");
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processing');
    }
};
