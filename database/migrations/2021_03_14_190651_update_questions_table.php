<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('order');
            $table->dropColumn('version');
            $table->dropColumn('uuid');
            $table->integer('rating_cat_id')->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->integer('order')->after('survey_id');
            $table->integer('version')->after('order');
            $table->string('uuid')->after('description');
            $table->dropColumn('rating_cat_id');
        });
    }
}
