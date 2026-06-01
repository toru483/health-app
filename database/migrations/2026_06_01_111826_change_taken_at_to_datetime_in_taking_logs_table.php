<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('taking_logs', function (Blueprint $table) {
            // taken_at カラムを date 型 から datetime 型 に変更（上書き）します
            $table->datetime('taken_at')->change();
        });
    }

    public function down(): void
    {
        Schema::table('taking_logs', function (Blueprint $table) {
            // ロールバック（元に戻す）した場合は date 型 に戻します
            $table->date('taken_at')->change();
        });
    }
};