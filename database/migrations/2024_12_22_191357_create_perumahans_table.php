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
        Schema::create('perumahans', function (Blueprint $table) {
            $table->id();
            $table->string('name_perum');
            $table->string('name_pengembang');
            $table->string('desa');
            $table->string('kecamatan');
            $table->integer('jumlah_unit');
            $table->integer('tahun_berdiri');
            $table->string('image');
            $table->integer('easting');
            $table->integer('norting');
            $table->polygon('geom');
            $table->point('lnglat');
            $table->integer('luas_perumahan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perumahans');
    }
};
