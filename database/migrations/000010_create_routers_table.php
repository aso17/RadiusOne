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
       Schema::create('routers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('ms_tenants')->cascadeOnDelete();

            $table->string('router_name', 100);
            $table->string('code', 50)->nullable();

            $table->enum('connection_type', ['VPN_RADIUS','IP_PUBLIC','LOCAL'])->index();

            $table->ipAddress('ip_address')->nullable();
            $table->unsignedSmallInteger('api_port')->default(8728);

            $table->string('username')->nullable();
            $table->text('password')->nullable(); // encrypt
            $table->text('secret')->nullable();   // encrypt

            $table->boolean('snmp_enabled')->default(false)->index();
            $table->string('snmp_community')->nullable();
            $table->unsignedSmallInteger('snmp_port')->default(161);

            $table->boolean('is_active')->default(true)->index();
            $table->timestampTz('last_seen_at')->nullable();

            $table->timestampsTz();

            $table->unique(['tenant_id', 'ip_address']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routers');
    }
};
