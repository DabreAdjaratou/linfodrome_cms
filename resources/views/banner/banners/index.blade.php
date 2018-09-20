@extends('layouts.administrator.master')
@section('title', 'Articles list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des banières') }}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-justify uk-text-small responsive" >	
	<thead>
            <tr>
            <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
			<th>{{ ('Titre') }}</th>
			<th>{{ ('Publiée') }}</th>
			<th>{{ ('Category') }}</th>
			<th>{{ ('Type') }}</th>
			<th>{{ ('url') }}</th>
			<th>{{ ('Debut de la publication') }}</th>
			<th>{{ ('fin de la publication') }}</th>
			<th>{{ ('Auteur') }}</th>                       
			<th>{{ ('Crée le') }}</th>
			<th>{{ ('Modifié le') }}</th>   
			<th>id</th>
		</tr>
	</thead>
	<tbody>
		@foreach($banners as $banner)
			<tr class="uk-text-small">
			<td ><input type="checkbox" name="" class="uk-checkbox"></td>
			<td> {{ $banner->title }}</td>
			<td> {{ $banner->published }}</td>
			<td> {{ $banner->getCategory->title }}</td>
			<td> {{ $banner->type }}</td>
			<td>{{$banner->url}}  </td>
			<td>{{$banner->start_publication_at}}  </td>
			<td>{{$banner->stop_publication_at}}  </td>
			<td> {{$banner->getAuthor->name }}</td>
			<td>{{$banner->created_at}}  </td>
			<td>{{$banner->updated_at}}  </td>
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