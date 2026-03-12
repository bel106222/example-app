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
        Schema::create('order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('serviceId')
                ->references('id')
                ->on('services');
            $table->foreignId('orderId')
                ->references('id')
                ->on('orders');
            $table->foreignId('userId')
                ->references('id')
                ->on('users');
            $table->boolean('isOnline')->default(false);
            $table->integer('quantity');
            $table->float('cost');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
