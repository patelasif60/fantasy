@component('mail::message')

Dear Chairman/Manager,
<br>
Gentle Reminder to moderate the newly created custom badges for teams.

<br>
<table border = "1">
	<thead>
		<td>Team Name</td>
		<td>Team Manager</td>
		<td>League Name</td>
		<td>Badge</td>
		<td>Manage</td>
	</th>
	<tbody>
	@foreach($emailDetails['teams'] as $team)
		<tr>
			<td>{{$team->name}}</td>
			<td>
				{{$team->consumer->user->first_name}} {{$team->consumer->user->last_name}}
			</td>
			<td>{{$team->teamDivision[0]->name}}</td>
			<td>
				<img src="{{$team->getMedia('crest')->last()->getUrl('thumb')}}" alt="{{$team->name}} Badge" title="{{$team->name}} Badge">
			</td>
			<td>
				<a href="{{route('admin.teams.edit', [ 'team' => $team->id ] )}}">Manage Team
				</a>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
