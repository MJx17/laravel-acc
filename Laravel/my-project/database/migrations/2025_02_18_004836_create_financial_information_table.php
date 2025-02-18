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
        Schema::create('financial_information', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('enrollment_id')->constrained()->onDelete('cascade');
            $table->enum('financier', ['Parents', 'Relatives', 'Guardian', 'Myself'])->nullable();
            $table->string('company_name')->nullable();
            $table->text('company_address')->nullable();
            $table->string('scholarship')->nullable();
            $table->text('income')->nullable();
            $table->string('contact_number', 20)->nullable();


            $table->string('relative_name')->nullable();
            $table->string('relationship')->nullable();
            $table->string('position_course')->nullable();
            $table->string('relative_contact_number', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_information');
    }
};
