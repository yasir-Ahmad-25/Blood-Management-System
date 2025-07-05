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
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique();
            $table->string('sex');
            $table->string('blood_type');
            $table->date('date_of_birth');
            $table->string('address')->nullable();
            $table->text('remarks')->nullable();
            $table->date('last_donation_date')->nullable();
            $table->date('next_donation_date')->nullable();
            $table->integer('donation_count')->default(0);
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donors');
    }
};
