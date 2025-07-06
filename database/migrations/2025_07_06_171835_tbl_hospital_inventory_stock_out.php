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
        Schema::create('tbl_hospital_inventory_stock_out', function(Blueprint $table){
            $table->id('stockout_id');
            $table->integer('hospital_id');
            $table->string('blood_type');
            $table->decimal('qty',12,2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
