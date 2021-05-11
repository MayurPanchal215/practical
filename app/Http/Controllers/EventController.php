<?php

namespace App\Http\Controllers;
use \Response;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Jobs\EventNotification;

class EventController extends Controller
{
	/**
	* This function is used for the view
	*/
    public function index()
    {
    	return view('index');
    }

    /**
    * This function is used to get the event list.
    * @param Request $request
    * @return Response
    */
    public function getEvents(Request $request)
    {
    	$startDate = $request->start_date;
    	$endDate   = $request->end_date;
    	$getData   = Event::fetchData($endDate);
		return Response::json(['status' => true, 'tableData' => $getData]);
    }

    /**
    * This function is used to send emails using job.
    * @param Request $request
    */
    public function sendNotification(Request $request)
    {
        $startDate = $request->start_date;
        $endDate   = $request->end_date;
        $eventIds  = Event::getEventData($startDate, $endDate);
        EventNotification::dispatch($eventIds);
        return Response::json(['status' => true, 'msg' => "success"]);
    }
}
