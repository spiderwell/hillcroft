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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('cat');
            $table->string('name');
            $table->decimal('price_ex_vat', $precision = 9, $scale = 4);
            $table->decimal('price_inc_vat', $precision = 9, $scale = 4);
            $table->integer('stock');
            $table->string('short_desc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
