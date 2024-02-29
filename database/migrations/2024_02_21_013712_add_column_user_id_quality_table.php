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
        Schema::table('quality', function (Blueprint $table) {
            $table->bigInteger('receive_details_id')->unsigned()->index();
            $table->foreign('receive_details_id')->references('id_receive_detail')->on('receive_details');
            
            $table->boolean('aprove');
            $table->string('observations')->nullable();
            
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quality', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['receive_details_id']);
            $table->dropColumn('receive_details_id');
            $table->dropColumn('aprove');
            $table->dropColumn('observations');
            $table->dropColumn('user_id');
        });
    }
};
