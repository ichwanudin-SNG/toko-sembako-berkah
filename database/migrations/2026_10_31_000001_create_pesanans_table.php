<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('no_pesanan', 30)->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'dibatalkan'])->default('menunggu');
            $table->unsignedBigInteger('total_harga');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->unsignedInteger('jumlah');
            $table->unsignedBigInteger('harga_saat_pesan');
            $table->unsignedBigInteger('subtotal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
        Schema::dropIfExists('pesanans');
    }
};
