<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id('id_assignment');
            $table->unsignedBigInteger('id_outlet');
            $table->unsignedBigInteger('id_user_surveyor')->nullable();
            $table->unsignedBigInteger('id_user_pemasang')->nullable();

            $table->string('no_sps')->nullable();
            $table->string('nama_brand')->nullable();
            $table->enum('prioritas', ['Standart', 'Urgent'])->default('Standart');
            $table->text('catatan_pekerjaan')->nullable();
            $table->string('file_mou')->nullable();

            $table->enum('status_workflow', [
                'Survey', 'Desain', 'Quotation', 'Produksi', 'Pemasangan', 'Penagihan', 'Lunas'
            ])->default('Survey');

            $table->date('tgl_sps')->nullable();
            $table->date('tgl_survey')->nullable();
            $table->date('tgl_quo')->nullable();
            $table->decimal('nilai_quo', 15, 2)->nullable();
            $table->string('no_po')->nullable();
            $table->decimal('nilai_po', 15, 2)->nullable();
            $table->date('tgl_pemasangan_done')->nullable();
            $table->decimal('nilai_realisasi', 15, 2)->nullable();

            $table->timestamps();

            // Relasi ke tabel Outlets dan Users (bawaan Laravel)
            $table->foreign('id_outlet')->references('id_outlet')->on('outlets')->onDelete('cascade');
            $table->foreign('id_user_surveyor')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_user_pemasang')->references('id')->on('users')->onDelete('set null');
        });
    }
    public function down(): void { Schema::dropIfExists('assignments'); }
};
