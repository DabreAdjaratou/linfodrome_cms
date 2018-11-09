@extends('layouts.administrator.master')
@section('title', 'Videos trash')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des videos en corbeille') }}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-smalluk-text-small">	
	<thead>
            <tr>
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
                        <th>{{ ('Restaurer') }}</th>
                        <th>{{ ('Supprimer') }}</th>
			<th>{{ ('id') }}</th>
                       
		</tr>
	</thead>
	<tbody>
		@foreach($videos as $video)
		<tr>
                        <td> {{ ucfirst($video->title) }}</td>
			<td> {{$video->getCategory->title}}</td>
			<td> {{ $video->featured }}</td>
			<td> {{ $video->published }}</td>
			<td> {{ucwords($video->getAuthor->name)}}</td>
			<td> {{ucwords($video->getCameraman->name)}}</td>
			<td> {{ucwords($video->getEditor->name)}}  </td>
			<td>{{$video->created_at}}</td>
			<td>{{ $video->start_publication_at}} </td>
			<td> {{$video->stop_publication_at}}</td>
			<td> {{$video->views}}</td>
                         <td> <a href="{{ route('videos.restore',['video'=>$video]) }}" ><span class="uk-text-success">Restaurer</span></a>

			</td>
			<td> <form action="{{ route('videos.destroy',['video'=>$video]) }}" method="POST" id="deleteForm" onsubmit="return confirm('Êtes vous sûre de bien vouloir supprimer cette video?')">
				@csrf
				@method('delete')
<button class="uk-button uk-button-link"><span class="uk-text-danger">Supprimer</span></button>
			</form> 
			</td>
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
<script type="text/javascript" src="{{asset('js/custom-datatable.js')}}" ></script>
@endsection
@endsection
