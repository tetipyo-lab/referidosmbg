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
        Schema::create('sms_outbox', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('provider_id')->constrained()->restrictOnDelete();
            $table->string('sender', 20);
            $table->string('recipient', 20);
            $table->text('message');
            $table->enum('status', ['pending', 'processing', 'sent', 'failed'])->default('pending');
            $table->string('id_sms_provider', 32)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_outbox');
    }
};
