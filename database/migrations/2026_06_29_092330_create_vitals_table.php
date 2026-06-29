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
        Schema::create('vitals', function (Blueprint $table) {
            $table->id();
            $table->decimal('weight', 4, 1)->nullable(); // 例: 65.5 (全体4桁、小数点1桁)
            $table->integer('blood_pressure_high')->nullable(); // 最高血圧
            $table->integer('blood_pressure_low')->nullable();  // 最低血圧
            $table->integer('blood_sugar')->nullable();         // 血糖値
            $table->timestamps(); // created_at (記録日時) と updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vitals');
    }
};
