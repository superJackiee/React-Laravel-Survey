<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateQuestionsOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions_options', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('type');
            $table->dropColumn('uuid');
            $table->dropColumn('version');
            $table->integer('rating_id')->after('question_id');
            $table->longText('content')->after('rating_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions_options', function (Blueprint $table) {
            $table->string('description')->after('question_id');
            $table->string('type')->after('description');
            $table->string('uuid')->after('type');
            $table->integer('version')->after('uuid');
            $table->dropColumn('rating_id');
            $table->dropColumn('content');
        });
    }
}
