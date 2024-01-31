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
        Schema::create('employees', function (Blueprint $table) {
            $table->id('id_employee');
            $table->string('names')->require();
            $table->string('last_names')->require();
            $table->string('phone')->require()->unique();
            $table->string('email')->require()->unique();
            $table->string('title');
            $table->string('address');
            $table->string('city');
            $table->string('postal_code');
            $table->date('birth');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
