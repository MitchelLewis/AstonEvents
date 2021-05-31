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
            $table->integer('eventOrganiserId');
            $table->string('location');
            $table->string('imgLocation');
            $table->integer('interestRanking');
        });

        DB::table('events')->insert(
            array(
              'id' => 1,
              'eventName' => 'Post Malone',
              'eventCategory' => 'Other',
              'dateTimeOfEvent' => "2038-01-19 03:14:07.999999",
              'eventDescription' => 'A concert hosted by Post Malone',
              'eventOrganiserId' => 12246,
              'location' => 'Manchester',
              'imgLocation' => '/',
              'interestRanking' => 1
            )
        );  

        DB::table('events')->insert(
            array(
              'id' => 2,
              'eventName' => 'Gandhi',
              'eventCategory' => 'Culture',
              'dateTimeOfEvent' => "2020-01-19 03:14:07.999999",
              'eventDescription' => 'A concert hosted by Gandhi',
              'eventOrganiserId' => 12246,
              'location' => 'Manchester',
              'imgLocation' => '/',
              'interestRanking' => 2
            )
        );

        DB::table('events')->insert(
            array(
              'id' => 3,
              'eventName' => 'Dave',
              'eventCategory' => 'Other',
              'dateTimeOfEvent' => "2020-01-19 03:14:07.999999",
              'eventDescription' => 'A concert hosted by Dave',
              'eventOrganiserId' => 12246,
              'location' => 'Manchester',
              'imgLocation' => '/',
              'interestRanking' => 3
            )
        );
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
