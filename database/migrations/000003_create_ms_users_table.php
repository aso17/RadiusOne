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
      Schema::create('ms_users', function (Blueprint $table) {
            $table->id();

            // Identity
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique()->nullable();
            $table->string('password');

            // Status & security
            $table->boolean('is_active')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();

            // Relation (explicit table)
            $table->foreignId('role_id')
                ->nullable()
                ->constrained('ms_roles')
                ->nullOnDelete();

            $table->foreignId('tenant_id')
                ->nullable()
                ->constrained('ms_tenants')
                ->nullOnDelete();

            // Audit
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });



      Schema::create('log_user_login', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')
            ->constrained('ms_users')
            ->cascadeOnDelete();

        $table->ipAddress('ip_address');
        $table->string('user_agent')->nullable();
        $table->boolean('is_success')->default(true);
        $table->string('fail_reason')->nullable();

        $table->timestamp('logged_in_at');
    });


    }

    /**
     * Reverse the migrations.
     */
   public function down(): void
    {
        Schema::dropIfExists('log_user_login');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('ms_users');
    }

};
