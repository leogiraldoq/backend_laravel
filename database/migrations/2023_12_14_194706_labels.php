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
        Schema::create("labels",function(Blueprint $table){
           $table->id("id_label");
           
           //foreing key customers
           $table->bigInteger("customer_id")->unsigned()->index();
           $table->foreign("customer_id")->references("id_costumer")->on("costumers");
           
           $table->string("name");
           $table->integer("quantity")->default(0);
           $table->longText("sample_image")->nullable()->comment("Image in base64 encode");
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labels');
    }
};
