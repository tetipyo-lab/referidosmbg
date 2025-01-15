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
        Schema::create('referred_links', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key for users
            $table->foreignId('link_id')->constrained('links')->onDelete('cascade'); // Foreign key for links
            $table->string('slug', 15)->unique(); // Unique referral code
            $table->string('short_links', 50)->unique(); // Unique referral code
            $table->integer('clicks')->default(0); // Click count
            $table->boolean('is_active')->default(true); // Active status
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referred_links');
    }
};
