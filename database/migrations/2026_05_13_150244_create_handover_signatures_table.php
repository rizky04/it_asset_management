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
        Schema::create('handover_signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('handover_id')->constrained()->cascadeOnDelete();
            $table->enum('role', ['dept_it', 'dept_head', 'hrd', 'penerima']);
            $table->string('signer_name');
            $table->string('signer_email')->nullable();
            $table->string('token', 64)->unique();
            $table->text('signature_data')->nullable(); // base64 drawn signature
            $table->timestamp('signed_at')->nullable();
            $table->string('signed_ip')->nullable();
            $table->timestamps();

            $table->unique(['handover_id', 'role']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('handover_signatures');
    }
};
