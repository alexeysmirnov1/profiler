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
        Schema::create('profiler_routes', function (Blueprint $table) {
            $table->id();

            $table->string('method');
            $table->string('url');
            $table->string('controller');
            $table->string('action');
            $table->jsonb('middleware');

            $table->unsignedFloat('routed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiler_routes');
    }
};
