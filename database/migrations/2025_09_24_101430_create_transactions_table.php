<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('kid_id');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('completed'); // pending, completed, failed
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kid_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
