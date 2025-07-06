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
        Schema::create('blood_inventories', function (Blueprint $table) {
            $table->id('blood_id');
            $table->string('blood_type');
            $table->decimal('volume', 8, 2)->default(0.00); // Quantity in liters
            $table->integer('donor_id')->nullable(); // Foreign key to donors table
            $table->date('collection_date')->nullable(); // Date of blood collection
            $table->date('expiration_date')->nullable(); // Date of blood collection
            $table->string('status')->default('available'); // Status of the blood (available, used, expired)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_inventories');
    }
};
