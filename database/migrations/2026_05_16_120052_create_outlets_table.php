<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('outlets', function (Blueprint $table) {
            $table->id('id_outlet');
            $table->string('nama_outlet');
            $table->text('alamat_lengkap')->nullable();
            $table->string('titik_koordinat')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('outlets'); }
};
