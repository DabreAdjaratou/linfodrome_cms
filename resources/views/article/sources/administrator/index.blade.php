@extends('layouts.administrator.master')
@section('title', 'Articles sources')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des sources d\'articles') }}</h3> @endsection 
<a href="{{ route('article-sources.create') }}">Nouveau</a> 
<a href="{{ route('article-sources.trash') }}">Corbeille</a> 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-text-small " {{--uk-text-small responsive --}}>	
	<thead>
            <tr>
            <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
			<th>{{ ('Titre') }}</th>
			<th> {{ ('Publiée') }}</th>
			<th>{{ ('Modifier') }}</th>
			<th>{{ ('Corbeille') }}</th>
			<th>{{ ('id') }}</th>
                       
		</tr>
	</thead>
	<tbody>
		@foreach($sources as $source)
		<tr>
			<td><input type="checkbox" name="" class="uk-checkbox"></td>
			<td> {{ucfirst($source->title) }}</td>
			<td> {{ $source->published }}</td>
			<td> <a href="{{ route('article-sources.edit',['source'=>$source]) }}" ><span class="uk-text-success">Modifier</span></a>

			</td>
                        <td> <a href="{{ route('article-sources.put-in-trash',['source'=>$source]) }}" ><span class="uk-text-danger">Mettre en corbeille</span></a>

			</td>
			
			<td>{{ $source->id }}</td>
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