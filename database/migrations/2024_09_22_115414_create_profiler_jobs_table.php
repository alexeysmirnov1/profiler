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
        Schema::create('profiler_jobs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('profiler_request_id')->constrained();

            $table->string('class');

            $table->unsignedFloat('queued_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiler_jobs');
    }
};
