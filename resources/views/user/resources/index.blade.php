@extends('layouts.administrator.master')
@section('title', 'Resources list')
@section('css')
@endsection
@section('content')
@parent
@section ('pageTitle')<h3>{{ ('Liste des ressources') }}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-striped uk-table-hover uk-table-small">	
<thead>
	<tr>
            <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
            <th>{{ ('Titre') }}</th>
	    <th>{{ ('Actions') }}</th>
	    <th>{{ ('id') }}</th>
	</tr>
	
</thead>
<tbody>

@foreach($resources as $resource)
	<tr>
            <td><input type="checkbox" name="" class="uk-checkbox"></td>
		<td>{{ $resource->title}}</td>
		<td>
			{{ $resource->actions }}
{{-- @foreach($resource->actions as $action)
{{ $action }}
@endforeach --}}

{{-- 
	{{ $resource->actions}} --}}
		</td>
		<td>{{ $resource->id }}</td>

	</tr>
@endforeach
</tbody>
<tfoot>
</tfoot>
</table>
@section('sidebar')
 @component('layouts.administrator.user-sidebar') @endcomponent 
@endsection
@section('js')

@endsection


@endsection
