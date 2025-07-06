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
        Schema::create('tbl_blood_requests' , function(Blueprint $table){
            $table->id('request_id');
            $table->integer('hospital_id');
            $table->string('blood_type');
            $table->decimal('qty',12,2);
            $table->string('status');
            $table->date('requested_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_blood_requests');
    }
};
