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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            
            $table->integer('kategori_id');
            $table->text('name');
            $table->text('sub_name');
            $table->text('slug');
            $table->text('image');
            $table->text('banner');
            $table->text('icon');
            $table->text('deskripsi')->default(null)->nullable();
            $table->text('placeholder');
            $table->text('placeholder2')->default(null)->nullable();
            $table->text('catatan')->default(null)->nullable();
            $table->tinyInteger('cek_target')->default(0);
            $table->text('pid');
            $table->tinyInteger('tipe');
            $table->bigInteger('untung');
            $table->bigInteger('fee')->default(0);

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
        Schema::dropIfExists('produk');
    }
};
