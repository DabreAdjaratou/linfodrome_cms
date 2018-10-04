@extends('layouts.administrator.master')
@section('title', 'Videos trash')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des videos en corbeille') }}</h3> @endsection 
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
                        <th>{{ ('Restaurer') }}</th>
                        <th>{{ ('Supprimer') }}</th>
			<th>{{ ('id') }}</th>
                       
		</tr>
	</thead>
	<tbody>
		@foreach($archives as $video)
		<tr>
			<td><input type="checkbox" name="" class="uk-checkbox"></td>
                        <td class="uk-table-expand"> {{ ucfirst($video->title) }}</td>
			<td class="uk-table-expand"> {{$video->getCategory->title}}</td>
			<td> {{ $video->featured }}</td>
			<td> {{ $video->published }}</td>
			<td class="uk-table-expand"> {{ucwords($video->getAuthor->name)}}</td>
			<td class="uk-table-expand"> {{ucwords($video->getCameraman->name)}}</td>
			<td class="uk-table-expand"> {{ucwords($video->getEditor->name)}}  </td>
			<td class="uk-table-expand">{{$video->created_at}}</td>
			<td class="uk-table-expand">{{ $video->start_publication_at}} </td>
			<td class="uk-table-expand"> {{$video->stop_publication_at}}</td>
			<td> {{$video->views}}</td>
                         <td> <a href="{{ route('video-archives.restore',['video'=>$video]) }}" ><span class="uk-text-success">Restaurer</span></a>

			</td>
			<td> <form action="{{ route('video-archives.destroy',['video'=>$video]) }}" method="POST" id="deleteForm" onsubmit="return confirm('Êtes vous sûre de bien vouloir supprimer cette video?')">
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

@endsection

@endsection
