<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('curriculum_id')->nullable();
            $table->string('code');
            $table->string('name');
            $table->integer('sks')->nullable();
            $table->enum('category', ['W', 'P'])->default('W');
            $table->enum('group', ['MPK', 'MKK', 'MKB', 'MBB'])->nullable();
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
        Schema::dropIfExists('courses');
    }
}
