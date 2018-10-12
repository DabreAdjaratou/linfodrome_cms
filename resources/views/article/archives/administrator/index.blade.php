@extends('layouts.administrator.master')
@section('title', 'Articles list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des articles') }}</h3> @endsection 
<a href="{{ route('articles.create') }}">Nouveau</a> 
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
			<th>{{ ('Modifié') }} </th>
                        <th>{{ ('Brouillon') }} </th>
			<th> {{ ('Corbeille') }}</th>
			<th>{{ ('id') }}</th>                       
		</tr>

	</thead>
	<tbody>
		{{-- {{ dd($article2s) }} --}}
		@foreach($articles2 as $article2)
		<tr class="uk-text-small">
			<td ><input type="checkbox" name="" class="uk-checkbox"></td>
			<td class="uk-table-expand"> {{ $article2->title }}</td>
			<td> {{ $article2->featured }}</td>
			<td> {{ $article2->published }}</td>
			<td> </td>
			<td> </td>
			{{-- <td class="uk-table-expand"> {{ $article2->getCategory->title }}</td> --}}
			{{-- <td class="uk-table-expand"> {{ $article2->getAuthor->name }}</td> --}}
			<td class="uk-table-expand"> {{ $article2->created_at }}</td>
<td> </td><td> </td>
			{{-- <td class="uk-table-expand">{{$article2->getRevision->last()['getModifier']['name']}} </td> --}}
			{{-- <td class="uk-table-expand">{{$article2->getRevision->last()['revised_at']}}  </td> --}}
			<td> {{ $article2->views }}</td>
			<td> {{ $article2->image }}</td>
			<td> <a href="{{ route('article-archives.edit',['article'=>$article2]) }}" ><span class="uk-text-success">Modifier</span></a>

			</td>
                        <td> <a href="{{ route('articles.put-in-draft',['article'=>$article2]) }}" ><span class="uk-text-success">Mettre au brouillon</span></a>

			</td>
			 <td> <a href="{{ route('article-archives.put-in-trash',['article'=>$article2]) }}" ><span class="uk-text-danger">Mettre en corbeille</span></a>

			</td>
			<td>{{ $article2->id }}</td>
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