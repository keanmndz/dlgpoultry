<a href="/admin/details">

	@if ($notif->data['update']['acknowledge'] == 'false')
		<b>{{ $notif->data['update']['fname'] }} {{ $notif->data['update']['lname'] }}</b> gave a <b>new update</b> on chicken health.

	@elseif ($notif->data['update']['acknowledge'] == 'true')
		<b>{{ $notif->data['user']['fname'] }} {{ $notif->data['user']['lname'] }}</b> has acknowledged the <b>{{ $notif->data['update']['created_at'] }} update</b> on chicken health and is <b>to be administered.</b>

	@elseif ($notif->data['update']['acknowledge'] == 'done')
		<b>{{ $notif->data['user']['fname'] }} {{ $notif->data['user']['lname'] }}</b> has administered the <b>{{ $notif->data['update']['created_at'] }} update</b> on chicken health.

	@endif

</a>
