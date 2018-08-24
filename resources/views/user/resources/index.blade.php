@extends('layouts.administrator.master')
@section('title', 'Group list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')<h3>Liste des ressources</h3> @endsection 
<table>	
<thead>
	<tr>
		<th>Titre</th>
		<th>Actions</th>
	    <th>id</th>

	</tr>
	

</thead>
<tbody>

@foreach($resources as $resource)


	<tr>
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

{{$resources->links()}}

@endsection
