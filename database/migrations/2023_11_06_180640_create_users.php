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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            
            //Foreign with employees table
            $table->bigInteger('employee_id')->require()->unique()->unsigned()->index();
            $table->foreign('employee_id')->references('id_employee')->on('employees')->onUpdate('cascade');
            
            $table->string('username')->unique()->require();
            $table->string('password')->unique();
            $table->boolean('active')->default(true);
            $table->dateTime('last_loguin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
