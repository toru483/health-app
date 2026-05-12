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
        Schema::table('medicines', function (Blueprint $table) {
            // 朝・昼・晩・寝る前などのフラグ（JSONや個別カラムで管理）
            // 今回はシンプルかつ強力な「時間帯ID」を保存する形にします
            $table->string('time_slots')->nullable()->comment('1:朝, 2:昼, 3:晩, 4:寝る前');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            //
        });
    }
};
