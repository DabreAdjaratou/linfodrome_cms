@extends('layouts.administrator.master')
@section('title', 'Articles categories')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des mise a jour pour cet article') }}</h3> @endsection 


@if(blank($article))
<div> ce article n'a pas encore été mofifié</div>
@else
<table>
	@foreach($article as $article)
	<tr>
		<td>{{ 'Titre : ' }}</td>
		<td>{{ $article->title }}</td>
	</tr>
	<tr>

		<td>{{ 'Category : ' }}</td>
		<td>{{ $article->getCategory->title }}</td>
	</tr>
	<tr>

		<td>{{ 'Auteur : ' }}</td>
		<td>{{ $article->getAuthor->name }}</td>
	</tr>
	<tr>
		<td>{{ 'Crée le: ' }}</td>
		<td>{{ $article->created_at }}</td>
	</tr>
	<tr>
		<td>{{ 'Modifications' }}</td>
		<td>
			<table class="uk-table uk-table-striped uk-table-hover uk-table-small">
				<thead>
					<tr>
						<th>{{ 'type' }}</th>
						<th>{{ 'Utilisateur' }}</th>					
						<th>{{ 'Date' }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($article->getRevision as $revision)
					<tr>
						<td>@if($revision->type=='update')
							{{ 'Mise a jour' }}
							@elseif($revision->type=='putInTrash')
							{{'Mise en corbeille' }}
							@elseif($revision->type=='putInDraft')
							{{ 'Mise au brouillon' }}
							@elseif($revision->type=='restore')
							{{ 'Restauration' }}
							@else
							{{ $revision->type }}
							@endif</td>
						<td>{{ $revision->getModifier->name }}</td>
						<td>{{ $revision->revised_at }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</td>
	</tr>
	
</table>
@endforeach
@endif
@section('sidebar')
@component('layouts.administrator.article-sidebar') @endcomponent 
@endsection

@section('js')
@endsection

@endsection