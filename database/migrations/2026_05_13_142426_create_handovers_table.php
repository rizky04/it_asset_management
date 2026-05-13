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
        Schema::create('handovers', function (Blueprint $table) {
            $table->id();
            $table->string('doc_number')->unique();
            $table->enum('type', ['laptop', 'add_on'])->default('laptop');
            $table->date('handover_date');
            $table->string('from_name');
            $table->string('from_position')->nullable();
            $table->string('from_department')->nullable();
            $table->string('dept_head')->nullable();
            $table->string('to_name');
            $table->string('to_position')->nullable();
            $table->string('to_department')->nullable();
            $table->string('to_address')->nullable();
            $table->string('device_label')->nullable();
            $table->string('merek')->nullable();
            $table->string('type_device')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('processor')->nullable();
            $table->string('storage')->nullable();
            $table->string('ram')->nullable();
            $table->string('screen_size')->nullable();
            $table->string('os')->nullable();
            $table->string('office_sw')->nullable();
            $table->json('software_list')->nullable();
            $table->json('accessories_list')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('handovers');
    }
};
