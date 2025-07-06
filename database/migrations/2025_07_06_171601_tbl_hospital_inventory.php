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
        Schema::create('tbl_hospital_inventory', function(Blueprint $table){
            $table->id('inventory_id');
            $table->integer('hospital_id');
            $table->string('blood_type');
            $table->decimal('qty',12,2);
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_hospital_inventory');
    }
};
