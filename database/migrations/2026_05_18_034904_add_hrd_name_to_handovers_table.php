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
            $table->string('hrd_name')->nullable()->after('dept_head');
        });
    }

    public function down(): void
    {
        Schema::table('handovers', function (Blueprint $table) {
            $table->dropColumn('hrd_name');
        });
    }
};
