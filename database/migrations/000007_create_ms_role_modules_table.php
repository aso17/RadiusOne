<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ms_role_modules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('role_id')
                  ->constrained('ms_roles')
                  ->cascadeOnDelete();

            $table->foreignId('module_id')
                  ->constrained('ms_modules')
                  ->cascadeOnDelete();

            // Prevent duplicate mapping
            $table->unique(['role_id', 'module_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_role_modules');
    }
};
