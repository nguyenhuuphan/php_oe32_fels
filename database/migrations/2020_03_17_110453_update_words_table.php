<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('words', function (Blueprint $table) {
            $table->string('spelling')->after('name');
            $table->integer('type')->after('name');
            $table->string('mean')->after('name');
            $table->string('def')->after('name');
            $table->string('image')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('words', function (Blueprint $table) {
            $table->dropColumn('spelling');
            $table->dropColumn('type');
            $table->dropColumn('mean');
            $table->dropColumn('def');
            $table->dropColumn('image');
        });
    }
}
