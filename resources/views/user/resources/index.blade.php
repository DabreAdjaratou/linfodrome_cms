@extends('layouts.administrator.master')
@section('title', 'Resources list')
@section('css')
@endsection
@section('content')
@parent
@section ('pageTitle')<h3>{{ ('Liste des ressources') }}</h3> @endsection 
<a href="{{ route('resources.create') }}">Nouveau</a> 
<table id="dataTable" class="uk-table uk-table-striped uk-table-hover uk-table-small" {{--uk-text-small responsive --}}>	
	<thead>
		<tr>
			<th>{{ ('Titre') }}</th>
			<th>{{ ('Nom à Affiché') }}</th>
			<th>{{ ('Actions') }}</th>
			<th>{{ ('Modifier') }}</th>
			<th>{{ ('Supprimer') }}</th>
			<th>{{ ('id') }}</th>
		</tr>

	</thead>
	<tbody>

		@foreach($resources as $resource)
		<tr>
			<td>{{ $resource->title}}</td>
			<td>{{ $resource->display_name}}</td>
			<td>@foreach ($resource->getActions as $action)
				{{ ucfirst($action->title) }}
			@endforeach </td>
			<td> <a href="{{ route('resources.edit',['resource'=>$resource]) }}" ><span class="uk-text-success">Modifier</span></a>

			</td>
			<td> <form action="{{ route('resources.destroy',['resource'=>$resource]) }}" method="POST" id="deleteForm" onsubmit="return confirm('Êtes vous sûre de bien vouloir supprimer cette resource?')">
				@csrf
				@method('delete')
<button class="uk-button uk-button-link"><span class="uk-text-danger">Supprimer</span></button>
			</form> 
			</td>
			<td>{{ $resource->id }}</td>

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
