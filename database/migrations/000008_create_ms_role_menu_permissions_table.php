<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ms_role_menu_permissions', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('role_id')
                  ->constrained('ms_roles')
                  ->cascadeOnDelete();

            $table->foreignId('menu_id')
                  ->constrained('ms_menus')
                  ->cascadeOnDelete();

            $table->foreignId('sub_menu_id')
                  ->nullable()
                  ->constrained('ms_sub_menus')
                  ->cascadeOnDelete();

            // Permissions
            $table->boolean('can_view')->default(false);
            $table->boolean('can_create')->default(false);
            $table->boolean('can_update')->default(false);
            $table->boolean('can_delete')->default(false);

            // Prevent duplicates
            $table->unique(['role_id', 'menu_id', 'sub_menu_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_role_menu_permissions');
    }
};
