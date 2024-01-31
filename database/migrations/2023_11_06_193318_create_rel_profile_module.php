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
        Schema::create('rel_profile_module', function (Blueprint $table) {
            $table->id();
            //Foreign key from profile table
            $table->bigInteger('profile_id')->unsigned()->index();
            $table->foreign('profile_id')->references('id_profile')->on('profiles')->onUpdate('cascade');

            //Foreign Key from modules table
            $table->bigInteger('module_id')->unsigned()->index();
            $table->foreign('module_id')->references('id_module')->on('modules')->onUpdate('cascade');

            $table->boolean('read')->default(false);
            $table->boolean('create')->default(false);
            $table->boolean('update')->default(false);
            $table->boolean('delete')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_profile_module');
    }
};
