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
    public function up()
{
    Schema::table('companies', function (Blueprint $table) {
        $table->string('street_address')->after('company_name');
        $table->string('representative_name')->after('street_address');
    });
}

public function down()
{
    Schema::table('companies', function (Blueprint $table) {
        $table->dropColumn(['street_address', 'representative_name']);
    });
}

};
