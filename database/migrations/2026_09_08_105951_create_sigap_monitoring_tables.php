<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Modifikasi tabel users (Asumsi tabel users bawaan Laravel sudah ada)
        // Pastikan Anda sudah menambahkan kolom 'role' dan 'status' di tabel users.
        if (! Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'operator', 'user'])->default('user')->after('password');
                $table->string('status')->default('aktif')->after('role');
            });
        }

        // 2. Tabel wilayah
        if (! Schema::hasTable('wilayah')) {
            Schema::create('wilayah', function (Blueprint $table) {
                $table->id('id_wilayah');
                $table->string('nama_wilayah');
                $table->string('kecamatan');
                $table->decimal('latitude', 10, 7)->nullable();
                $table->decimal('longitude', 10, 7)->nullable();
                $table->timestamps();
            });
        }

        // 3. Tabel jenis_bencana
        if (! Schema::hasTable('jenis_bencana')) {
            Schema::create('jenis_bencana', function (Blueprint $table) {
                $table->id('id_bencana');
                $table->string('nama_bencana');
                $table->text('deskripsi')->nullable();
                $table->timestamps();
            });
        }

        // 4. Tabel indikator
        if (! Schema::hasTable('indikator')) {
            Schema::create('indikator', function (Blueprint $table) {
                $table->id('id_indikator');
                $table->string('nama_indikator');
                $table->enum('kategori', ['ancaman', 'kerentanan', 'kapasitas', 'kesiapsiagaan']);
                $table->string('satuan')->nullable();
                $table->decimal('bobot', 5, 2)->default(0);
                $table->text('deskripsi')->nullable();
                $table->timestamps();
            });
        }

        // 5. Tabel monitoring (Tanpa id_indikator, sesuai instruksi)
        if (! Schema::hasTable('monitoring')) {
            Schema::create('monitoring', function (Blueprint $table) {
                $table->id('id_monitoring');
                $table->unsignedBigInteger('id_wilayah');
                $table->unsignedBigInteger('id_bencana');
                $table->date('tanggal');
                $table->string('tingkat_ancaman')->nullable();
                $table->string('tingkat_kerentanan')->nullable();
                $table->string('kapasitas')->nullable();
                $table->string('tingkat_risiko')->nullable();
                $table->string('tingkat_kesiapsiagaan')->nullable();
                $table->string('status')->default('aktif');
                $table->timestamps();

                $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onDelete('cascade');
                $table->foreign('id_bencana')->references('id_bencana')->on('jenis_bencana')->onDelete('cascade');
            });
        }

        // 6. Tabel monitoring_indikator
        if (! Schema::hasTable('monitoring_indikator')) {
            Schema::create('monitoring_indikator', function (Blueprint $table) {
                $table->id('id_monitoring_indikator');
                $table->unsignedBigInteger('id_monitoring');
                $table->unsignedBigInteger('id_indikator');
                $table->decimal('nilai', 8, 2);
                $table->string('status_indikator')->nullable();
                $table->timestamps();

                $table->foreign('id_monitoring')->references('id_monitoring')->on('monitoring')->onDelete('cascade');
                $table->foreign('id_indikator')->references('id_indikator')->on('indikator')->onDelete('cascade');

                // Unique Constraint
                $table->unique(['id_monitoring', 'id_indikator'], 'unique_monitoring_indikator');
            });
        }

        // 7. Tabel kejadian_bencana
        if (! Schema::hasTable('kejadian_bencana')) {
            Schema::create('kejadian_bencana', function (Blueprint $table) {
                $table->id('id_kejadian');
                $table->unsignedBigInteger('id_wilayah');
                $table->unsignedBigInteger('id_bencana');
                $table->dateTime('tanggal_waktu');
                $table->string('lokasi');
                $table->text('keterangan')->nullable();
                $table->text('dampak')->nullable();
                $table->enum('status', ['tercatat', 'diverifikasi'])->default('tercatat');
                $table->timestamps();

                $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onDelete('cascade');
                $table->foreign('id_bencana')->references('id_bencana')->on('jenis_bencana')->onDelete('cascade');
            });
        }

        // 8. Tabel dokumentasi_kejadian
        if (! Schema::hasTable('dokumentasi_kejadian')) {
            Schema::create('dokumentasi_kejadian', function (Blueprint $table) {
                $table->id('id_dokumentasi');
                $table->unsignedBigInteger('id_kejadian');
                $table->unsignedBigInteger('id_user'); // asumsikan tabel users primary key nya 'id'
                $table->string('file_path');
                $table->string('nama_file');
                $table->string('caption')->nullable();
                $table->string('sumber')->nullable();
                $table->date('tanggal_pengambilan')->nullable();
                $table->enum('status_verifikasi', ['belum diverifikasi', 'terverifikasi'])->default('belum diverifikasi');
                $table->timestamps();

                $table->foreign('id_kejadian')->references('id_kejadian')->on('kejadian_bencana')->onDelete('cascade');
                $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // 12. Tabel sumber_data (Harus dibuat sebelum data_gempa dan data_muka_laut)
        if (! Schema::hasTable('sumber_data')) {
            Schema::create('sumber_data', function (Blueprint $table) {
                $table->id('id_sumber');
                $table->string('nama_sumber');
                $table->string('jenis_data');
                $table->string('url_sumber')->nullable();
                $table->enum('tipe_sumber', ['API', 'GIS', 'file', 'manual']);
                $table->enum('status', ['aktif', 'tidak_aktif', 'gagal'])->default('aktif');
                $table->dateTime('last_update')->nullable();
                $table->text('keterangan')->nullable();
                $table->timestamps();
            });
        }

        // 9. Tabel data_gempa
        if (! Schema::hasTable('data_gempa')) {
            Schema::create('data_gempa', function (Blueprint $table) {
                $table->id('id_gempa');
                $table->string('event_id')->unique();
                $table->unsignedBigInteger('id_sumber');
                $table->dateTime('tanggal_waktu');
                $table->decimal('magnitudo', 4, 2);
                $table->decimal('kedalaman', 8, 2);
                $table->decimal('latitude', 10, 7);
                $table->decimal('longitude', 10, 7);
                $table->string('wilayah');
                $table->string('potensi_tsunami')->nullable();
                $table->text('dirasakan')->nullable();
                $table->string('sumber');
                $table->string('status_data')->nullable();
                $table->timestamps();

                $table->foreign('id_sumber')->references('id_sumber')->on('sumber_data')->onDelete('cascade');
            });
        }

        // 10. Tabel data_muka_laut
        if (! Schema::hasTable('data_muka_laut')) {
            Schema::create('data_muka_laut', function (Blueprint $table) {
                $table->id('id_data_laut');
                $table->unsignedBigInteger('id_sumber');
                $table->string('stasiun');
                $table->dateTime('tanggal_waktu');
                $table->decimal('tinggi_muka_laut', 8, 2);
                $table->string('satuan');
                $table->enum('jenis_data', ['sensor', 'model', 'simulasi']);
                $table->string('sumber');
                $table->string('status')->nullable();
                $table->timestamps();

                $table->foreign('id_sumber')->references('id_sumber')->on('sumber_data')->onDelete('cascade');
            });
        }

        // 11. Tabel peringatan
        if (! Schema::hasTable('peringatan')) {
            Schema::create('peringatan', function (Blueprint $table) {
                $table->id('id_peringatan');
                $table->unsignedBigInteger('id_kejadian')->nullable();
                $table->unsignedBigInteger('id_wilayah')->nullable();
                $table->string('jenis_peringatan');
                $table->enum('tingkat', ['informasi', 'waspada', 'siaga', 'peringatan']);
                $table->text('pesan');
                $table->dateTime('waktu_mulai');
                $table->dateTime('waktu_selesai')->nullable();
                $table->enum('status', ['aktif', 'selesai'])->default('aktif');
                $table->timestamps();

                $table->foreign('id_kejadian')->references('id_kejadian')->on('kejadian_bencana')->onDelete('set null');
                $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onDelete('set null');
            });
        }

        // 13. Tabel simulasi
        if (! Schema::hasTable('simulasi')) {
            Schema::create('simulasi', function (Blueprint $table) {
                $table->id('id_simulasi');
                $table->unsignedBigInteger('id_user');
                $table->enum('jenis_simulasi', ['gempa', 'tsunami', 'likuefaksi']);
                $table->string('nama_skenario');
                $table->json('parameter');
                $table->text('hasil_ringkas')->nullable();
                $table->string('status')->nullable();
                $table->timestamps();

                $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // 14. Tabel layer_gis
        if (! Schema::hasTable('layer_gis')) {
            Schema::create('layer_gis', function (Blueprint $table) {
                $table->id('id_layer');
                $table->string('nama_layer');
                $table->string('jenis_layer');
                $table->string('sumber')->nullable();
                $table->string('format_data'); // e.g., GeoJSON, SHP
                $table->string('file_path');
                $table->string('status')->default('aktif');
                $table->text('keterangan')->nullable();
                $table->timestamps();
            });
        }

        // 15. Tabel log_data
        if (! Schema::hasTable('log_data')) {
            Schema::create('log_data', function (Blueprint $table) {
                $table->id('id_log');
                $table->unsignedBigInteger('id_user')->nullable();
                $table->string('sumber');
                $table->string('jenis_data');
                $table->dateTime('waktu_update');
                $table->enum('status_koneksi', ['terhubung', 'terputus', 'gagal']);
                $table->text('keterangan')->nullable();
                $table->timestamps();

                $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('log_data');
        Schema::dropIfExists('layer_gis');
        Schema::dropIfExists('simulasi');
        Schema::dropIfExists('peringatan');
        Schema::dropIfExists('data_muka_laut');
        Schema::dropIfExists('data_gempa');
        Schema::dropIfExists('sumber_data');
        Schema::dropIfExists('dokumentasi_kejadian');
        Schema::dropIfExists('kejadian_bencana');
        Schema::dropIfExists('monitoring_indikator');
        Schema::dropIfExists('monitoring');
        Schema::dropIfExists('indikator');
        Schema::dropIfExists('jenis_bencana');
        Schema::dropIfExists('wilayah');

        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['role', 'status']);
            });
        }
    }
};
