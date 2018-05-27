<a href="/admin/details">

	@if ($notif->data['approval']['status'] == 'Pending')
		<b>{{ $notif->data['user']['fname'] }} {{ $notif->data['user']['lname'] }}</b> made a <b>new action</b> on <b>{{ $notif->data['approval']['module'] }}.</b>

	@elseif ($notif->data['approval']['status'] == 'Approved')
		<b>{{ $notif->data['user']['fname'] }} {{ $notif->data['user']['lname'] }}</b> has <b>approved</b> your action on <b>{{ $notif->data['approval']['module'] }}.</b>
	
	@elseif ($notif->data['approval']['status'] == 'Disapproved')
		<b>{{ $notif->data['user']['fname'] }} {{ $notif->data['user']['lname'] }}</b> has <b>disapproved</b> the <b>{{ $notif->data['approval']['module'] }}.</b>

	@endif

</a>
