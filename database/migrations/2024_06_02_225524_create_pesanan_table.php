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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();

            $table->text('kode');
            $table->text('kategori');
            $table->text('produk');
            $table->text('layanan');
            $table->bigInteger('layanan_hj');
            $table->bigInteger('layanan_hb');
            $table->bigInteger('layanan_untung');
            $table->text('layanan_pid');
            $table->text('target');
            $table->text('target2')->default(null)->nullable();
            $table->text('target_hasil')->default(null)->nullable();
            $table->text('metode')->default(null)->nullable();
            $table->bigInteger('metode_fee')->default(0);
            $table->bigInteger('metode_fee_hasil')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->bigInteger('fee')->default(0);
            $table->bigInteger('fee_hasil')->default(0);
            $table->bigInteger('total');
            $table->bigInteger('total_pure');
            $table->integer('voucher_id')->default(0);
            $table->text('voucher')->default(null)->nullable();
            $table->bigInteger('voucher_ketentuan')->default(0);
            $table->bigInteger('voucher_potongan')->default(0);
            $table->integer('potongan_id')->default(0);
            $table->bigInteger('potongan')->default(0);
            $table->tinyInteger('tipe');
            $table->text('pid')->default(null)->nullable();
            $table->text('informasi')->default(null)->nullable();
            $table->text('email');
            $table->text('no_wa')->default(null)->nullable();
            $table->text('uuid')->default(null)->nullable();
            $table->text('token')->default(null)->nullable();

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
        Schema::dropIfExists('pesanan');
    }
};
