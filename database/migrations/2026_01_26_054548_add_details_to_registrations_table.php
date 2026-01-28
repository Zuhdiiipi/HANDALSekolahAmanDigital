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
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('jenjang')->after('school_name');
            $table->string('province')->default('Sulawesi Selatan');
            $table->string('city')->after('province');
            $table->string('district')->after('city');
            $table->string('village')->after('district');
            $table->string('contact_number')->after('email');
            $table->string('npsn')->after('contact_number');
            $table->string('assessment_letter')->nullable(); // Simpan path file PDF
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            //
        });
    }
};
