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
        Schema::create('costumers', function (Blueprint $table) {
            $table->id('id_costumer');
            $table->string('name')->require();
            
            //Foreign key to table pick_up_company
            $table->bigInteger('pick_up_company_id')->require()->unsigned()->index();
            $table->foreign('pick_up_company_id')->references('id_pick_up_company')->on('pick_up_company');
            
            $table->longText('sample_instruction')->nullable()->comment('Image that show how is the label going to');
            $table->string('ups_account')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costumers');
    }
};
