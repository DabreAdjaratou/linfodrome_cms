@extends('layouts.administrator.master')
@section('title', 'Articles list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des articles') }}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-justify uk-text-small responsive" >	
	<thead>
            <tr>
            <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
			<th>{{ ('Titre') }}</th>
			<th>{{ ('Publiée') }}</th>
			<th>{{ ('Category') }}</th>
			<th>{{ ('Image') }}</th>
			<th>{{ ('créé le') }}</th>
			<th>{{ ('Dernière modification') }}</th>
			<th>{{ ('Modifié le') }}</th>
			<th>{{ ('Nbre de vue') }}</th>
			<th>{{ ('Image') }}</th>
			<th>{{ ('id') }}</th>                       
		</tr>
	</thead>
	<tbody>
		@foreach($banners as $banner)
		<tr class="uk-text-small">
			<td ><input type="checkbox" name="" class="uk-checkbox"></td>
			<td class="uk-table-expand"> {{ $banner->title }}</td>
			<td> {!! ($banner->featured== 1 ? '<span>✔</span>': '<span>✖</span>' )!!}</td>
			<td> {!! ($banner->published== 1 ? '<span> ✔</span>': '<span>✖</span>' )!!}</td>
			<td class="uk-table-expand"> {{ $banner->getCategory->title }}</td>
			<td class="uk-table-expand"> {{ $banner->getAutor->name }}</td>
			<td class="uk-table-expand"> {{ $banner->created_at }}</td>
			<td class="uk-table-expand">{{$banner->getRevision->last()['getModifier']['name']}} </td>
			<td class="uk-table-expand">{{$banner->getRevision->last()['revised_at']}}  </td>
			<td> {{ $banner->views }}</td>
			<td> {{ $banner->image }}</td>
			<td>{{ $banner->id }}</td>
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