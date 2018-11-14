@extends('layouts.administrator.master')
@section('title', 'Actions list')
@section('css')
@endsection
@section('content')
@parent
@section ('pageTitle')<h3>  {{ ('Liste des actions') }}</h3> @endsection 
<a href="{{ route('actions.create') }}">Nouveau</a> 
<table id="dataTable" class="uk-table uk-table-striped uk-table-hover uk-table-small" {{--uk-text-small responsive --}}>	
<thead>
	<tr>
		<th>{{ ('Titre') }}<i class="fas fa-sort uk-margin-left"></th>
		<th>{{ (' Nom affiché') }}<i class="fas fa-sort uk-margin-left"></th>
		<th>{{ ('Modifier') }}</th>
		<th>{{ ('Supprimer') }}</th>
	<th>{{ ('id') }}<i class="fas fa-sort uk-margin-left"></th>

	</tr>
	

</thead>
<tbody>

@foreach($actions as $action)


	<tr>
		<td>{{ ucfirst($action->title) }}</td>
		<td>{{ ucfirst($action->display_name )}}</td>
		<td> <a href="{{ route('actions.edit',['action'=>$action]) }}" ><span class="uk-text-success">Modifier</span></a>

			</td>
			<td> <form action="{{ route('actions.destroy',['action'=>$action]) }}" method="POST" id="deleteForm" onsubmit="return confirm('Êtes vous sûre de bien vouloir supprimer cette action?')">
				@csrf
				@method('delete')
<button class="uk-button uk-button-link"><span class="uk-text-danger">Supprimer</span></button>
			</form> 
			</td>
		<td>{{ $action->id }}</td>

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
