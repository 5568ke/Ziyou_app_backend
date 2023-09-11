<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameroomTable extends Migration
{
    public function up()
    {
        Schema::create('gameroom', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('paper_id');
            // 添加其他列
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gameroom');
    }
}

