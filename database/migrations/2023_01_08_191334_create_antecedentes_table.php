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
        Schema::create('antecedentes', function (Blueprint $table) {
            $table->id();
            $table->integer('px');
            $table->integer('user');
            $table->string('familiares')->nullable();
            $table->string('no_familiares')->nullable();
            $table->string('patologicos')->nullable();
            $table->string('no_patologicos')->nullable();
            $table->string('ginecologicos')->nullable();
            $table->string('qxs')->nullable();
            $table->string('psiquiatricos')->nullable();
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
        Schema::dropIfExists('antecedentes');
    }
};
