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
        Schema::create('sms_inbox', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained()->restrictOnDelete();
            $table->string('sender', 20);
            $table->string('recipient', 20);
            $table->text('message');
            $table->boolean('seen')->default(false);
            $table->timestamp('received_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_inbox');
    }
};