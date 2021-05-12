<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTemplateFromSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn('header_left_template_id');
            $table->dropColumn('header_left_template_content');
            $table->dropColumn('header_center_template_id');
            $table->dropColumn('header_center_template_content');
            $table->dropColumn('header_right_template_id');
            $table->dropColumn('header_right_template_content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->integer('header_left_template_id')->after('languages');
            $table->string('header_left_template_content')->after('header_left_template_id');
            $table->integer('header_center_template_id')->after('header_left_template_content');
            $table->string('header_center_template_content')->after('header_center_template_id');
            $table->integer('header_right_template_id')->after('header_center_template_content');
            $table->string('header_right_template_content')->after('header_right_template_id');
        });
    }
}
