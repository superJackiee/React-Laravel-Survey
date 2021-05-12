<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('firstName')->after('password');
            $table->string('lastName')->after('firstName');
            $table->string('employeeId')->after('lastName');
            $table->string('photo')->after('employeeId');
            $table->integer('branch')->after('photo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->after('active');
            $table->dropColumn('firstName');
            $table->dropColumn('lastName');
            $table->dropColumn('employeeId');
            $table->dropColumn('photo');
            $table->dropColumn('branch');
        });
    }
}
