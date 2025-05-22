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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');         // 商品名
            $table->string('maker');        // メーカー名
            $table->integer('price');       // 価格
            $table->integer('stock');       // 在庫数
            $table->text('comment')->nullable(); // コメント
            $table->string('image')->nullable(); // 画像パス
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
        Schema::dropIfExists('products');
    }
};
