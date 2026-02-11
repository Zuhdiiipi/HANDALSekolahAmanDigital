<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('survey_question_options', function (Blueprint $table) {
            $table->text('option_text')->change();
        });
    }

    public function down()
    {
        Schema::table('survey_question_options', function (Blueprint $table) {
            $table->string('option_text')->change();
        });
    }
};
