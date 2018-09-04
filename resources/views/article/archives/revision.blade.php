@extends('layouts.administrator.master')
@section('title', 'Articles revision')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des revisions') }}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-justify uk-text-small responsive" >	
	<thead>
            <tr>
            <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
			<th>{{ ('Article') }}</th>
			<th>{{ ('Category') }}</th>
			<th>{{ ('Auteur') }}</th>
			<th>{{ ('créé le') }}</th>
			<th>{{ ('Revisions') }}</th>
			                     
		</tr>
	</thead>
	<tbody>
		@foreach($articles as $article)
		<tr class="uk-text-small">
			<td ><input type="checkbox" name="" class="uk-checkbox"></td>
			<td class="uk-table-expand"> {{ $article->title }}</td>
			<td class="uk-table-expand"> {{ $article->getCategory->title }}</td>
			<td class="uk-table-expand"> {{ $article->getAuthor->name }}</td>
			<td class="uk-table-expand"> {{ $article->created_at }}</td>
			<td class="uk-table-expand">
				@foreach($article->getRevision as $revision)
{{$revision}} 
				@endforeach
			</td>
			<td></td>
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