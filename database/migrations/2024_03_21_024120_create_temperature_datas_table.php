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
        Schema::create('temperature_datas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_chamber')->nullable()->constrained('chambers')->onDelete('cascade');
            $table->foreignId('id_client')->nullable()->constrained('clients')->onDelete('cascade');
            $table->string('temperature_data');
            $table->text('keterangan')->nullable();
            $table->timestamps(); // Ini akan membuat kolom created_at dan updated_at
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temperature_datas');
    }
};
