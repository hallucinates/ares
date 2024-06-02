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
        Schema::create('master_layanan', function (Blueprint $table) {
            $table->id();

            $table->text('m_code');
            $table->text('m_server')->default(null)->nullable();
            $table->text('code');
            $table->text('brand');
            $table->text('name');
            $table->bigInteger('price_basic');
            $table->bigInteger('price_premium');
            $table->bigInteger('price_special');
            $table->text('server')->default(null)->nullable();
            $table->text('status');
            $table->tinyInteger('tipe');

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
        Schema::dropIfExists('master_layanan');
    }
};
