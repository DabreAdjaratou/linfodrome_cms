@extends('layouts.administrator.master')
@section('title', 'Action list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')<h3>  Liste des actions</h3> @endsection 
<table>	
<thead>
	<tr>
		<th>Titre</th>
		<th> Display name</th>
	<th>id</th>

	</tr>
	

</thead>
<tbody>

@foreach($actions as $action)


	<tr>
		<td>{{ $action->title }}</td>
		<td>{{ $action->display_name }}</td>
		<td>{{ $action->id }}</td>

	</tr>
@endforeach
</tbody>

<tfoot>
	


</tfoot>

</table>

{{$actions->links()}}

@endsection
