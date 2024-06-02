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
        Schema::create('populer', function (Blueprint $table) {
            $table->id();

            $table->integer('produk_id');
            $table->tinyInteger('urutan');

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
        Schema::dropIfExists('populer');
    }
};
