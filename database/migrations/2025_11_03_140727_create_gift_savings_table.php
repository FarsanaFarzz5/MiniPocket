<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gift_savings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gift_id');
            $table->unsignedBigInteger('kid_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->decimal('saved_amount', 10, 2);
            $table->enum('type', ['debit', 'credit'])->default('debit');
            $table->enum('status', ['pending', 'completed'])->default('completed');
            $table->timestamps();

            $table->foreign('gift_id')->references('id')->on('gifts')->onDelete('cascade');
            $table->foreign('kid_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gift_savings');
    }
};
