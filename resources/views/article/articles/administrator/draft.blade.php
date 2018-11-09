@extends('layouts.administrator.master')
@section('title', 'Articles draft')
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
			<th>{{ ('Category') }}</th>
			<th>{{ ('Auteur') }}</th>
			<th>{{ ('créé le') }}</th>
			<th>{{ ('Dernière modification') }}</th>
			<th>{{ ('Modifié le') }}</th>
			<th>{{ ('Nbre de vue') }}</th>
			<th>{{ ('Image') }}</th>
                       <th>{{ ('Modifier') }}</th>
                         <th>{{ ('Corbeille') }}</th>
			<th>{{ ('id') }}</th>                       
		</tr>
	</thead>
	<tbody>
		@foreach($articles as $article)
  	<tr>
			<td> {{ $article->title }}</td>
			<td> {{ $article->getCategory->title }}</td>
			<td> {{ $article->getAuthor->name }}</td>
			<td> {{ $article->created_at }}</td>
			<td>{{$article->getRevision->last()['getModifier']['name']}} </td>
			<td>{{$article->getRevision->last()['revised_at']}}  </td>
			<td> {{ $article->views }}</td>
			<td> {{ $article->image }}</td>
                         <td> <a href="{{ route('articles.edit',['article'=>$article]) }}" ><span class="uk-text-success">Modifier</span></a>

			</td>
			 <td> <a href="{{ route('articles.put-in-trash',['article'=>$article]) }}" ><span class="uk-text-danger">Mettre au brouillon</span></a>

			</td>
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