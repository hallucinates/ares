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
        Schema::create('potongan', function (Blueprint $table) {
            $table->id();

            $table->integer('layanan_id');
            $table->bigInteger('potongan');
            $table->bigInteger('harga');
            $table->timestamp('dari');
            $table->timestamp('sampai');
            $table->tinyInteger('status');

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
        Schema::dropIfExists('potongan');
    }
};
