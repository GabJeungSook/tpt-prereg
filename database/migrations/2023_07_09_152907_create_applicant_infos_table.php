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
        Schema::create('applicant_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('birthplace');
            $table->date('birthday');
            $table->text('present_address');
            $table->text('permanent_address');
            $table->string('contact_number');
            $table->string('gender');
            $table->string('religion');
            $table->string('tribe');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_infos');
    }
};
