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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id');

            $table->string('router_name', 100);
            $table->string('code', 50)->nullable();

            $table->enum('connection_type', [
                'VPN_RADIUS',
                'IP_PUBLIC',
                'LOCAL'
            ]);

            $table->ipAddress('ip_address');
            $table->unsignedSmallInteger('api_port')->default(8728);

            $table->string('username')->nullable();
            $table->text('password')->nullable();
            $table->text('secret')->nullable();

            $table->boolean('snmp_enabled')->default(false);
            $table->string('snmp_community')->nullable();
            $table->unsignedSmallInteger('snmp_port')->default(161);

            $table->boolean('is_active')->default(true);
            $table->timestampTz('last_seen_at')->nullable();

            $table->timestampsTz();

            $table->unique(['tenant_id', 'ip_address']);
            $table->index('tenant_id');

            $table->foreign('tenant_id')
                ->references('id')
                ->on('ms_tenants')
                ->onDelete('cascade');
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
