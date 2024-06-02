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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();

            $table->text('pesanan_kode');
            $table->text('kode_unik');
            $table->text('layanan_id');
            $table->text('layanan');
            $table->bigInteger('nominal');
            $table->bigInteger('balance');
            $table->bigInteger('fee');
            $table->text('catatan');
            $table->text('va')->default(null)->nullable();
            $table->text('ewallet_phone')->default(null)->nullable();
            $table->text('sign');
            $table->text('pid');
            $table->timestamp('kadaluarsa');
            $table->text('url');
            $table->tinyInteger('status')->default(1);

            $table->timestamps();

            $table->string('created_by')->default('system');
            $table->text('updated_by')->default(null)->nullable();
            $table->tinyInteger('deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
