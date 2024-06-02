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
        Schema::create('layanan', function (Blueprint $table) {
            $table->id();

            $table->integer('kategori_id');
            $table->integer('produk_id');
            $table->integer('label_id');
            $table->text('name');
            $table->bigInteger('hj');
            $table->bigInteger('hb');
            $table->tinyInteger('kustom')->default(0);
            $table->tinyInteger('status');
            $table->text('pid');
            $table->text('m_code');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};
