@extends('layouts.administrator.master')
@section('title', 'Banners list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des banières') }}</h3> @endsection 
<a href="{{ route('banners.create') }}">Nouveau</a> 
<a href="{{ route('banners.trash') }}">Corbeille</a> 

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
			<th> {{ ('Modifier') }}</th>
			<th> {{ ('Corbeille') }}</th>  
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
			@if($banner->type==0)
			<td> {{('Image')}}</td>
			@else
			<td> {{('Personnalisé')}}</td>
			@endif
			<td>{{$banner->url}}  </td>
			<td>{{$banner->start_publication_at}}  </td>
			<td>{{$banner->stop_publication_at}}  </td>
			<td> {{$banner->getAuthor->name }}</td>
			<td>{{$banner->created_at}}  </td>
			<td>{{$banner->updated_at}}  </td><td> <a href="{{ route('banners.edit',['banner'=>$banner]) }}" ><span class="uk-text-success">Modifier</span></a>
			</td>
			<td> <a href="{{ route('banners.put-in-trash',['banner'=>$banner]) }}" ><span class="uk-text-danger">Mettre en corbeille</span></a>
			</td>
			<td>{{ $banner->id }}</td>
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

@endsection

@endsection