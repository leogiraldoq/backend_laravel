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
        Schema::create('rel_user_profile', function (Blueprint $table) {
            $table->id();
             
            //Foreing key users
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id_user')->on('users')->onUpdate('cascade');

            //Foreing key profiles
            $table->bigInteger('profile_id')->unsigned()->index();
            $table->foreign('profile_id')->references('id_profile')->on('profiles')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_user_profile');
    }
};
