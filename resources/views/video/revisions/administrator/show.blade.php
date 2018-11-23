@extends('layouts.administrator.master')
@section('title', 'Videos categories')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des mise a jour pour cet video') }}</h3> @endsection 


@if(blank($video))
<div> ce video n'a pas encore été mofifié</div>
@else
<table>
	@foreach($video as $video)
	<tr>
		<td>{{ 'Titre : ' }}</td>
		<td>{{ $video->title }}</td>
	</tr>
	<tr>

		<td>{{ 'Category : ' }}</td>
		<td>{{ $video->getCategory->title }}</td>
	</tr>
	<tr>

		<td>{{ 'Auteur : ' }}</td>
		<td>{{ $video->getAuthor->name }}</td>
	</tr>
	<tr>
		<td>{{ 'Crée le: ' }}</td>
		<td>{{ $video->created_at }}</td>
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
					@foreach($video->getRevision as $revision)
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
@component('layouts.administrator.video-sidebar') @endcomponent 
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/custom-datatable.js') }}"></script>
@endsection

@endsection