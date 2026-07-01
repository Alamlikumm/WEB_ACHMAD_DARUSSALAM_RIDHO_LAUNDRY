<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trans_order', function (Blueprint $table) {
            $table->id();
            $table->integer('id_customer');
            $table->string('order_code', 50);
            $table->date('order_date');
            $table->date('order_end_date')->nullable();
            $table->tinyInteger('order_status')->default(0)->comment('0=Baru, 1=Sudah diambil');
            $table->integer('order_pay')->nullable();
            $table->integer('order_change')->nullable();
            $table->integer('total');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trans_order');
    }
};
