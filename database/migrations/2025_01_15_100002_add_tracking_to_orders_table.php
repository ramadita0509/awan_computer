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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('tracking_number')->nullable()->after('courier_service')->comment('Nomor resi pengiriman');
            $table->string('courier_name')->nullable()->after('tracking_number')->comment('Nama jasa pengiriman');
            $table->date('shipped_date')->nullable()->after('courier_name')->comment('Tanggal pengiriman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['tracking_number', 'courier_name', 'shipped_date']);
        });
    }
};

