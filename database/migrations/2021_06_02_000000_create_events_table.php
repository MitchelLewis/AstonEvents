<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('eventName');
            $table->enum('eventCategory', array(
                'Sport', 'Culture', 'Other'
            ));
            $table->dateTime('dateTimeOfEvent');
            $table->string('eventDescription');
            $table->bigInteger('eventOrganiserId')->unsigned();
            $table->string('location');
            $table->integer('interestRanking');
            $table->integer('relatedContent')->nullable()->default(NULL);
            
            $table->foreign('eventOrganiserId')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
