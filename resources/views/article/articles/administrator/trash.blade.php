@extends('layouts.administrator.master')
@section('title', 'Articles trash')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des articles en corbeille') }}</h3> @endsection
<table id="dataTable" class="uk-table uk-table-responsive uk-table-hover uk-table-striped uk-text-small" >	
	<thead>
            <tr>
			<th>{{ ('Titre') }}</th>
			<th>{{ ('A la une') }}</th>
			<th>{{ ('Publiée') }}</th>
			<th>{{ ('Category') }}</th>
			<th>{{ ('Auteur') }}</th>
			<th>{{ ('créé le') }}</th>
			<th>{{ ('Dernière modification') }}</th>
			<th>{{ ('Modifié le') }}</th>
			<th>{{ ('Nbre de vue') }}</th>
			<th>{{ ('Image') }}</th>
			<th>{{ ('Supprimer') }}</th>
			<th>{{ ('restaurer') }}</th>
			<th>{{ ('id') }}</th>                       
		</tr>
	</thead>
	<tbody>
		@foreach($articles as $article)
  	<tr>
			<td> {{ $article->title }}</td>
			<td> {{ $article->featured }}</td>
			<td> {{ $article->published }}</td>
			<td> {{ $article->getCategory->title }}</td>
			<td> {{ $article->getAuthor->name }}</td>
			<td> {{ $article->created_at }}</td>
			<td>{{$article->getRevision->last()['getModifier']['name']}} </td>
			<td>{{$article->getRevision->last()['revised_at']}}  </td>
			<td> {{ $article->views }}</td>
			<td> {{ $article->image }}</td>
			<td> <form action="{{ route('articles.destroy',['article'=>$article]) }}" method="POST" id="deleteForm" onsubmit="return confirm('Êtes vous sûre de bien vouloir supprimer cet article?')">
				@csrf
				@method('delete')
<button class="uk-button uk-button-link"><span class="uk-text-danger">Supprimer</span></button>
			</form> 
			</td>
			<td> <a href="{{ route('articles.restore',['article'=>$article]) }}" ><span class="uk-text-success">Restaurer</span></a></td>
			<td>{{ $article->id }}</td>
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
<script type="text/javascript" src="{{asset('js/custom-datatable.js')}}" ></script>
@endsection

@endsection