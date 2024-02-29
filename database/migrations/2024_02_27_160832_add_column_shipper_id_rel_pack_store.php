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
        Schema::table('rel_pack_stores', function (Blueprint $table) {
            $table->bigInteger('shipper_id')->unsigned()->index();
            $table->foreign('shipper_id')->on('shippers')->references('id_shipper');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rel_pack_stores', function (Blueprint $table) {
            $table->dropForeign(['shipper_id']);
            $table->dropColumn('shipper_id');
        });
    }
};
