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
        Schema::create('silsilahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('foto')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->enum('status', ['hidup', 'meninggal'])->default('hidup');
            $table->date('tgl_meninggal')->nullable();

            // Relasi pernikahan
            $table->foreignId('pasangan_id')->nullable()->constrained('silsilahs')->nullOnDelete();

            // Relasi orang tua
            $table->foreignId('ayah_id')->nullable()->constrained('silsilahs')->nullOnDelete();
            $table->foreignId('ibu_id')->nullable()->constrained('silsilahs')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('silsilahs');
    }
};
