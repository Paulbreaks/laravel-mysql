<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('test_table', function (Blueprint $table) {
            $table->id();                  // Уникальный автоинкрементный идентификатор
            $table->string('name');        // Поле для текста (например, имя)
            $table->timestamps();          // Поля created_at и updated_at
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('test_table'); // Убедитесь, что название совпадает с названием в методе up
    }
};
