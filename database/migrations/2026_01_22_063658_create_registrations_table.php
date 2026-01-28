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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('school_name');
            $table->string('jenjang');
            $table->string('province')->default('Sulawesi Selatan');
            $table->string('city');
            $table->string('district');
            $table->string('village');
            $table->string('email')->unique();
            $table->string('contact_number');
            $table->string('npsn');
            $table->string('assessment_letter')->nullable(); 
            $table->text('address');
            $table->enum('status', ['pending', 'approved', 'rejected', 'verified'])->default('pending');
            $table->text('admin_notes')->nullable(); 
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
