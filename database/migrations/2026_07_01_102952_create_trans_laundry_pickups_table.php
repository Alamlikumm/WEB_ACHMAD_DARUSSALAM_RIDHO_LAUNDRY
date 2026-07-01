<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trans_laundry_pickup', function (Blueprint $table) {
            $table->id();
            $table->integer('id_order');
            $table->integer('id_customer');
            $table->dateTime('pickup_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trans_laundry_pickup');
    }
};
