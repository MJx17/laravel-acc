<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained('enrollments')->onDelete('cascade'); // Link to enrollment
            $table->decimal('tuition_fee', 10, 2); // Tuition fee
            $table->decimal('lab_fee', 10, 2); // Lab fee
            $table->decimal('miscellaneous_fee', 10, 2); // Miscellaneous fee
            $table->decimal('other_fee', 10, 2)->nullable(); // Other fees (if any)
            
            // Payment status for each payment phase
            $table->decimal('initial_payment', 10, 2)->default(0);
            $table->decimal('prelims_payment', 10, 2)->default(0);
            $table->decimal('midterms_payment', 10, 2)->default(0);
            $table->decimal('pre_final_payment', 10, 2)->default(0);
            $table->decimal('final_payment', 10, 2)->default(0);

            $table->timestamps(); // Track creation and update times
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_payments');
    }
}
