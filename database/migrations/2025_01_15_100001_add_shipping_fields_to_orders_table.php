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
            $table->string('proof_of_payment')->nullable()->after('payment_method')->comment('Bukti transfer');
            $table->string('courier')->nullable()->after('proof_of_payment')->comment('Kurir: kurir_toko, jet');
            $table->string('courier_service')->nullable()->after('courier')->comment('Layanan kurir (contoh: EZ, REG, ONS untuk J&T)');
            $table->string('destination_city')->nullable()->after('courier_service')->comment('Kota tujuan untuk perhitungan ongkir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['proof_of_payment', 'courier', 'courier_service', 'destination_city']);
        });
    }
};

