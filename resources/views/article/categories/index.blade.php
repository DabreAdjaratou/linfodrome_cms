@extends('layouts.administrator.master')
@section('title', 'Articles categories')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des categories d\'articles') }}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-text-small " {{--uk-text-small responsive --}}>	
	<thead>
            <tr>
            <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
			<th>{{ ('Titre') }}</th>
			<th>{{ ('id') }}</th>
                       
		</tr>
	</thead>
	<tbody>
		@foreach($categories as $category)
		<tr>
			<td><input type="checkbox" name="" class="uk-checkbox"></td>
			<td> {{ ucfirst($category->title) }}</td>
			<td>{{ $category->id }}</td>
                </tr>
		@endforeach
	</tbody>
	<tfoot>
	</tfoot>
</table>
@section('sidebar')
 @component('layouts.administrator.article-sidebar') @endcomponent 
@endsection

@section('js')

@endsection

@endsection
