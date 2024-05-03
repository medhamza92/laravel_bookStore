<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('isbn')->unique();
            $table->string('name');
            $table->string('year');
            $table->integer('page');
            $table->foreignId('publisher_id')->constrained('publishers');
            $table->foreignId('category_id')->constrained('categorybooks')->nullable(); // Add this line for category relationship
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('books');
    }
}
