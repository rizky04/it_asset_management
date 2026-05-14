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
        Schema::table('handovers', function (Blueprint $table) {
            $table->enum('status', ['active', 'returned'])->default('active')->after('notes');
            $table->timestamp('returned_at')->nullable()->after('status');
            $table->string('returned_by')->nullable()->after('returned_at');
            $table->text('return_notes')->nullable()->after('returned_by');
        });
    }

    public function down(): void
    {
        Schema::table('handovers', function (Blueprint $table) {
            $table->dropColumn(['status', 'returned_at', 'returned_by', 'return_notes']);
        });
    }
};
