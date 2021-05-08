<h2>Upcoming Event Detail</h2>
@foreach($eventData as $event)
	<b>Event Name:</b> {{ $event->name }}<br/>
	<b>Event Location:</b> {{ $event->location }}<br/>
@endforeach