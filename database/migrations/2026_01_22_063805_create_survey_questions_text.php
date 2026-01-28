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
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('survey_categories')->onDelete('cascade');
            $table->text('question_text');
            $table->enum('type', ['mcq', 'checkbox', 'number', 'text']); // mcq = pilihan ganda
            $table->integer('weight'); // Bobot pertanyaan dalam kategori tersebut
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_questions_text');
    }
};
