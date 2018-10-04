@extends('layouts.administrator.master')
@section('title', 'Articles trash')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des articles en corbeille') }}</h3> @endsection
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-justify uk-text-small responsive" >	
	<thead>
            <tr>
            <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
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
		@foreach($archives as $article)
  	<tr class="uk-text-small">
			<td ><input type="checkbox" name="" class="uk-checkbox"></td>
			<td class="uk-table-expand"> {{ $article->title }}</td>
			<td> {{ $article->featured }}</td>
			<td> {{ $article->published }}</td>
			<td class="uk-table-expand"> {{ $article->getCategory->title }}</td>
			<td class="uk-table-expand"> {{ $article->getAuthor->name }}</td>
			<td class="uk-table-expand"> {{ $article->created_at }}</td>
			<td class="uk-table-expand">{{$article->getRevision->last()['getModifier']['name']}} </td>
			<td class="uk-table-expand">{{$article->getRevision->last()['revised_at']}}  </td>
			<td> {{ $article->views }}</td>
			<td> {{ $article->image }}</td>
			<td> <form action="{{ route('article-archives.destroy',['article'=>$article]) }}" method="POST" id="deleteForm" onsubmit="return confirm('Êtes vous sûre de bien vouloir supprimer cet article?')">
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

@endsection

@endsection