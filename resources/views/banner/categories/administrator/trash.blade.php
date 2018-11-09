@extends('layouts.administrator.master')
@section('title', 'Banners categories trash')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des categories de bannièere en corbeille') }}</h3> @endsection 

<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-text-small " {{--uk-text-small responsive --}}>	
	<thead>
            <tr>
            <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
			<th>{{ ('Titre') }}<i class="fas fa-sort uk-margin-left"></i></th>
			<th>{{ ('Publiée') }}<i class="fas fa-sort uk-margin-left"></i></th>
			<th> {{ ('Restaurer') }}</th>
			<th> {{ ('Supprimer') }}</th>
			<th>{{ ('id') }}<i class="fas fa-sort uk-margin-left"></i></th>

                       
		</tr>
	</thead>
	<tbody>
		@foreach($categories as $category)
		<tr>
			<td><input type="checkbox" name="" class="uk-checkbox"></td>
			<td> {{ ucfirst($category->title) }}</td>
			<td>{{ $category->published }}</td>
			<td> <a href="{{ route('banner-categories.restore',['category'=>$category]) }}" ><span class="uk-text-success">Restaurer</span></a>

			</td>
			<td> <form action="{{ route('banner-categories.destroy',['category'=>$category]) }}" method="POST" id="deleteForm" onsubmit="return confirm('Êtes vous sûre de bien vouloir supprimer cette categorie?')">
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
 @component('layouts.administrator.banner-sidebar') @endcomponent 
@endsection
@section('js')
 <script type="text/javascript" src="{{ asset('js/custom-datatable.js') }}"></script>

@endsection

@endsection
