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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            // 💡 処方箋（第3階層）とのリレーション（親が消えたらお薬も消える cascade）
            $table->foreignId('prescription_id')
                  ->constrained()
                  ->onDelete('cascade');
                  
            $table->string('name'); // 薬剤名（例: ロキソニン錠60mg）
            $table->string('dosage'); // 1回の服用量（例: 1錠、5ml）
            
            // 💡 服用タイミングをBoolean型で管理（インデックスを貼り、マイページでの爆速検索を実現）
            $table->boolean('timing_morning')->default(false)->index();
            $table->boolean('timing_noon')->default(false)->index();
            $table->boolean('timing_night')->default(false)->index();
            $table->boolean('timing_before_sleep')->default(false)->index();
            
            $table->text('notes')->nullable(); // 備考（例: 食後30分以内に服用、など）
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};