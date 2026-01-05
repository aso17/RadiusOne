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
            Schema::create('ms_tenants', function (Blueprint $table) {
          
            $table->id();
            // Identity
            $table->string('name', 150);
            $table->string('slug', 50)->unique();
            $table->string('code', 20)->unique();
            $table->string('domain', 150)->unique()->nullable();

            // Branding
            $table->string('logo_path')->nullable();
            $table->string('primary_color', 10)->default('#2563EB');
            $table->string('theme', 20)->default('light');

            // Status
            $table->boolean('is_active')->default(true);

            // Audit (string, NO FK)
            $table->string('created_by', 50)->nullable(); // system / admin@email
            $table->string('updated_by', 50)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_tenants');
    }
};
