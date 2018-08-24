@extends('layouts.administrator.master')
@section('title', 'Users list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')<h3>  Liste des niveaux d'accès</h3> @endsection 
<table class="uk-table uk-table-striped uk-table-hover uk-table-small">	
	<thead>
		<tr>
			<th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
			<th>Titre</th>
			<th>groupes utilisateurs</th>
			<th>id</th>
		</tr>
	</thead>
	<tbody>
		@foreach($accessLevels as $access)
		<tr>
			<td><input type="checkbox" name="{{ $access->title }}" class="uk-checkbox"></td>
			<td> <a href="">{{ $access->title }}</a></td>
			<td>
@for ($i = 0; $i < sizeof($access->userGroups); $i++)
   
    @endif
@endfor
				@foreach( $access->userGroups as $group)
				{{ $group->title.','}}
				@endforeach
			</td>
			<td>{{ $access->id }}</td>
		</tr>
		@endforeach
	</tbody>
	<tfoot>
	</tfoot>
</table>

{{$accessLevels->links()}}

@endsection
