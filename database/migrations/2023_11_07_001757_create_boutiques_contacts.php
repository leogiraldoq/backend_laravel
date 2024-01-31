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
        Schema::create('boutiques_contacts', function (Blueprint $table) {
            $table->id('id_boutique_contact');
            
            //Foreign key boutiques table
            $table->bigInteger('boutique_id')->unsigned()->index();
            $table->foreign('boutique_id')->references('id_boutique')->on('boutiques');

            $table->string('contact_name')->require();
            $table->string('phone')->require();
            $table->string('email')->require();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boutiques_contacts');
    }
};
