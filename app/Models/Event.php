<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['eventName', 'eventCategory', 'location', 'dateTimeOfEvent', 'imgLocation', 'interestRanking', 'eventDescription', 'eventOrganiserId', 'relatedContent'];

    use HasFactory;
}
