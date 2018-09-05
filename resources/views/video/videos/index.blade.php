@extends('layouts.administrator.master')
@section('title', 'Videos list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des videos') }}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-justify uk-text-small responsive">	
	<thead>
            <tr>
            <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
			<th>{{ ('Titre de la video') }}</th>
			<th>{{ ('Categorie') }}</th>
			<th>{{ ('A la Une') }}</th>
			<th>{{ ('Publiée') }}</th>
			<th>{{ ('Journaliste') }}</th>
			<th>{{ ('Cameraman') }}</th>
			<th>{{ ('Monteur') }}</th>
			<th>{{ ('crée lé') }}</th>
			<th>{{ ('Debut publication') }}</th>
			<th>{{ ('fin publication') }}</th>
			<th>{{ ('Nbre de vue') }}</th>
			<th>{{ ('id') }}</th>
                       
		</tr>
	</thead>
	<tbody>
		@foreach($videos as $video)
		<tr>
			<td><input type="checkbox" name="" class="uk-checkbox"></td>
                        <td class="uk-table-expand"> {{ ucfirst($video->title) }}</td>
			<td class="uk-table-expand"> {{$video->getCategory->title}}</td>
			<td> {!! ($video->featured== 1 ? '<span>✔</span>': '<span>✖</span>' )!!}</td>
			<td> {!! ($video->published== 1 ? '<span> ✔</span>': '<span>✖</span>' )!!}</td>
			<td class="uk-table-expand"> {{$video->getAuthor->name}}</td>
			<td class="uk-table-expand"> {{$video->data->cameraman}}</td>
			<td class="uk-table-expand"> {{$video->data->editor}}  </td>
			<td class="uk-table-expand">{{$video->created_at}}</td>
			<td class="uk-table-expand">{{ $video->start_publication_at}} </td>
			<td class="uk-table-expand"> {{$video->stop_publication_at}}</td>
			<td> {{$video->views}}</td>
			<td>{{ $video->id }}</td>
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

@endsection

@endsection
