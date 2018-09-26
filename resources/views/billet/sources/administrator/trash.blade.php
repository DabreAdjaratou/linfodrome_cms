@extends('layouts.administrator.master')
@section('title', 'Billets sources trash')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des sources de billets en corbeille') }}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-text-small " {{--uk-text-small responsive --}}>	
	<thead>
            <tr>
            <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
			<th>{{ ('Titre') }}</th>
			<th> {{ ('Publiée') }}</th>
			<th>{{ ('Restaurer') }}</th>
			<th>{{ ('Supprimer') }}</th>
			<th>{{ ('id') }}</th>
                       
		</tr>
	</thead>
	<tbody>
		@foreach($sources as $source)
		<tr>
			<td><input type="checkbox" name="" class="uk-checkbox"></td>
			<td> {{ucfirst($source->title) }}</td>
			<td> {{ $source->published }}</td>
			<td> <a href="{{ route('billet-sources.restore',['source'=>$source]) }}" ><span class="uk-text-success">Restaurer</span></a>

			</td>
			<td> <form action="{{ route('billet-sources.destroy',['source'=>$source]) }}" method="POST" id="deleteForm" onsubmit="return confirm('Êtes vous sûre de bien vouloir supprimer cette source?')">
				@csrf
				@method('delete')
<button class="uk-button uk-button-link"><span class="uk-text-danger">Supprimer</span></button>
			</form> 
			</td>
			<td>{{ $source->id }}</td>
                </tr>
		@endforeach
	</tbody>
	<tfoot>
	</tfoot>
</table>
@section('sidebar')
 @component('layouts.administrator.billet-sidebar') @endcomponent 
@endsection

@section('js')

@endsection

@endsection