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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Parent/Kid names
            $table->string('first_name', 50);
            $table->string('second_name', 50)->nullable();

            // Contact info
            $table->string('email', 100)->unique();
            $table->string('phone_no', 15)->nullable();

            // Authentication
            $table->string('password', 255);

            // 1 = parent, 2 = kid
            $table->tinyInteger('role')->default(0);

            // For kids linked to a parent
            $table->unsignedBigInteger('parent_id')->nullable();

            // Standard timestamps
            $table->timestamps();

            // Foreign key (optional)
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First drop the foreign key before dropping the table
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });

        Schema::dropIfExists('users');
    }
};
