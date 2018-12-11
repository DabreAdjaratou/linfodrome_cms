@extends('layouts.administrator.master')
@section('title', 'Access levels list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{{ ('Liste des niveaux d\'accès') }}}</h3> @endsection 
	
	<a href="{{ route('access-levels.create') }}" ">Nouveau</a>

<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small" {{--uk-text-small responsive --}}/>	
	<thead>
            <tr>
			<th>{{ ('Titre') }}<i class="fas fa-sort uk-margin-left"></th>
			<th>{{ ('Groupes utilisateurs') }}<i class="fas fa-sort uk-margin-left"></th>
			<th>{{ ('Modifier') }}</th>
			<th>{{ ('Supprimer') }}</th>
			<th>{{ ('Id') }}<i class="fas fa-sort uk-margin-left"></th>
                       
		</tr>
	</thead>
	<tbody>
		@foreach($accessLevels as $accessLevel)
		<tr>
			<td> <a href="{{ route('access-levels.edit',['access-level'=>$accessLevel]) }}">{{ ucfirst($accessLevel->title) }}</a></td>
			<td>@foreach ($accessLevel->getGroups as $group)
				{{ ucfirst($group->title) }}
			@endforeach </td>
			<td> <a href="{{ route('access-levels.edit',['access-level'=>$accessLevel]) }}" ><span class="uk-text-success">Modifier</span></a>

			</td>
			<td> <form action="{{ route('access-levels.destroy',['access-level'=>$accessLevel]) }}" method="POST" id="deleteForm" onsubmit="return confirm('Êtes vous sûre de bien vouloir supprimer ce niveau d\'acces?')">
				@csrf
				@method('delete')
<button class="uk-button uk-button-link"><span class="uk-text-danger">Supprimer</span></button>
			</form> 
			</td>
			<td>{{ $accessLevel->id }}
			</tr>
		@endforeach
	</tbody>
	<tfoot>
	</tfoot>
</table>
@section('sidebar')
 @component('layouts.administrator.user-sidebar') @endcomponent 
@endsection
@section('js')
 <script type="text/javascript" src="{{ asset('js/custom-datatable.js') }}"></script>
@endsection

@endsection
