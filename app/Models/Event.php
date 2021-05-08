<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public $table    = 'events';

    protected $dates = ['start_date','end_date'];
    
    /**
     * The events that belong to the user.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'event_user');
    }

    /**
     * This function is used to get events data.
     * @param $startDate
     * @param $endDate
     */
    static function getEventData($startDate, $endDate)
    {
    	$startDate = Carbon::createFromFormat('d/m/Y',$startDate)->format('Y-m-d');
    	$endDate   = Carbon::createFromFormat('d/m/Y',$endDate)->format('Y-m-d');
    	return Event::whereDate('start_date', '>=', $startDate)->whereDate('end_date', '<=',$endDate)->get();
    }
}
