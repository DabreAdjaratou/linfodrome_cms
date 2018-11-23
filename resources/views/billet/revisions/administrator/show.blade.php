@extends('layouts.administrator.master')
@section('title', 'Billets categories')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des mise a jour pour cet billet') }}</h3> @endsection 


@if(blank($billet))
<div> ce billet n'a pas encore été mofifié</div>
@else
<table>
	@foreach($billet as $billet)
	<tr>
		<td>{{ 'Titre : ' }}</td>
		<td>{{ $billet->title }}</td>
	</tr>
	<tr>

		<td>{{ 'Category : ' }}</td>
		<td>{{ $billet->getCategory->title }}</td>
	</tr>
	<tr>

		<td>{{ 'Auteur : ' }}</td>
		<td>{{ $billet->getAuthor->name }}</td>
	</tr>
	<tr>
		<td>{{ 'Crée le: ' }}</td>
		<td>{{ $billet->created_at }}</td>
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
					@foreach($billet->getRevision as $revision)
					<tr>
						<td>
							@if($revision->type=='update')
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
@component('layouts.administrator.billet-sidebar') @endcomponent 
@endsection

@section('js')
@endsection

@endsection