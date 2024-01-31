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
        Schema::create('rel_boutique_customer_intructions', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger("boutique_id")->unsigned()->index();
            $table->foreign("boutique_id")->references("id_boutique")->on("boutiques");
            
            $table->bigInteger("rel_cus_ins_id")->unsigned()->index();
            $table->foreign("rel_cus_ins_id")->references("id")->on("rel_costumer_instruction");
            
            $table->boolean("principal")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_boutique_customer_intructions');
    }
};
