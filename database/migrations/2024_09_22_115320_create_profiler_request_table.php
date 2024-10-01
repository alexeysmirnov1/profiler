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
        Schema::create('profiler_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('profiler_route_id')->constrained();

            $table->jsonb('params');
            $table->jsonb('body');
            $table->jsonb('server');
            $table->unsignedFloat('memory');

            $table->unsignedFloat('requested_at');
            $table->unsignedFloat('responsed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiler_requests');
    }
};
