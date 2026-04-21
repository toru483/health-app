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
            $table->foreignId('prescription_id')->constrained()->onDelete('cascade');
            $table->string('name')->comment('薬の名前');
            $table->integer('dosage_amount')->comment('1回の分量');
            $table->string('dosage_unit')->default('錠')->comment('単位（錠、包、mlなど）');
            $table->string('frequency')->comment('服用頻度（朝昼晩など）');
            $table->text('notes')->nullable()->comment('備考（食後、眠気注意など）');
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
