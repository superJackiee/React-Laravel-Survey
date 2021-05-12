<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('header_left_template_id');
            $table->string('header_left_template_content');
            $table->integer('header_center_template_id');
            $table->string('header_center_template_content');
            $table->integer('header_right_template_id');
            $table->string('header_right_template_content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('template');
    }
}
