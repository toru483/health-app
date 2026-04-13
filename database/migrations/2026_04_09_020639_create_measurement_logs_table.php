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
        Schema::create('measurement_logs', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 種類（血糖値/血圧）
            $table->float('value_1'); // 数値1
            $table->float('value_2')->nullable(); // 数値2
            $table->dateTime('measured_at'); // 測定日時
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measurement_logs');
    }
};
