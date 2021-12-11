<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            # url formatting
            $table->string('slug')->unique();

            $table->string('title');
            $table->longText('description');
            $table->string('organizer');
            $table->string('geo');
            $table->string('location');
            $table->dateTime('schedule');

            $table->integer('amount');
            $table->integer('supply');

            # listing interval
            $table->dateTime('start');
            $table->dateTime('end');

            # link
            $table->unsignedBigInteger('user_id');

            # time
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
        Schema::dropIfExists('tickets');
    }
}
