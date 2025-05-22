<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
// ↑生成されたマイグレーションファイルに↓を記述
public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('maker');
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->string('maker'); // rollback 用
    });
}

};
