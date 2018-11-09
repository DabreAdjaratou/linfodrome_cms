@extends('layouts.administrator.master')
@section('title', 'Videos categories trash')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des categories de video en corbeille') }}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-text-small ">	
	<thead>
            <tr>
			<th>{{ ('Titre') }}<i class="fas fa-sort uk-margin-left"></i></th>
			<th>{{ ('publiée') }}<i class="fas fa-sort uk-margin-left"></i></th>
			<th> {{ ('Restaurer') }}</th>
			<th> {{ ('Supprimer') }}</th>
			<th>{{ ('id') }}<i class="fas fa-sort uk-margin-left"></i></th>

                       
		</tr>
	</thead>
	<tbody>
		@foreach($categories as $category)
		<tr>
			<td> {{ ucfirst($category->title) }}</td>
			<td>{{ $category->published }}</td>
			<td> <a href="{{ route('video-categories.restore',['category'=>$category]) }}" ><span class="uk-text-success">Restaurer</span></a>

			</td>
			<td> <form action="{{ route('video-categories.destroy',['category'=>$category]) }}" method="POST" id="deleteForm" onsubmit="return confirm('Êtes vous sûre de bien vouloir supprimer cette categorie?')">
				@csrf
				@method('delete')
<button class="uk-button uk-button-link"><span class="uk-text-danger">Supprimer</span></button>
			</form> 
			</td>
			<td>{{ $category->id }}</td>
                </tr>
		@endforeach
	</tbody>
	<tfoot>
	</tfoot>
</table>
@section('sidebar')
 @component('layouts.administrator.video-sidebar') @endcomponent 
@endsection
@section('js')
 <script type="text/javascript" src="{{ asset('js/custom-datatable.js') }}"></script>
@endsection
@endsection

