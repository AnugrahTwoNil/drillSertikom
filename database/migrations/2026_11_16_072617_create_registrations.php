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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('workshop_id')->constrained('workshops')->onDelete('cascade');
            $table->string('order_id')->unique();
            $table->enum('status', ['pending', 'paid', 'expired', 'failed'])->default('pending');
            $table->string('payment_url')->nullable();
            $table->timestamps();
            $table->unique(['workshop_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workshop_user');
    }
};
