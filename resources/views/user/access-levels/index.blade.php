@extends('layouts.administrator.master')
@section('title', 'Access levels list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{{ ('Liste des niveaux d\'accès') }}}</h3> @endsection 
<div class="uk-margin ">	
	<a href="{{ route('access-levels.create') }}" class="uk-button uk-button-primary uk-button-small">Nouveau</a>
</div>
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small" {{--uk-text-small responsive --}}/>	
	<thead>
            <tr>
			<th>{{ ('Titre') }}</th>
			<th>{{ ('Groupes utilisateurs') }}</th>
			<th>{{ ('Modifier') }}</th>
			<th>{{ ('Supprimer') }}</th>
			<th>{{ ('Id') }}</th>
                       
		</tr>
	</thead>
	<tbody>
		@foreach($accessLevels as $accessLevel)
		<tr>
			<td> <a href="">{{ ucfirst($accessLevel->title) }}</a></td>
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

@endsection

@endsection
