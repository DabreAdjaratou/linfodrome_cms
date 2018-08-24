@extends('layouts.administrator.master')
@section('title', 'Users list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')<h3>Liste des utilisateurs</h3> @endsection 
<table class="uk-table uk-table-striped uk-table-small">	
<thead>
	<tr>
		<th>Nom</th>
		<th>Email</th>
		<th>Actif</th>
		<th>titre </th>
		<th>autre adresse</th>
		<th>id</th>

	</tr>
	

</thead>
<tbody>

@foreach($users as $user)
<tr>
		<td>{{ $user->Name}}</td>
      	<td>{{ $user->Email}}</td>
      	<td>{{ $user->is_active}}</td>
      	<td>{{ $user->data }}</td>
</tr>
@endforeach
</tbody>

<tfoot>
	


</tfoot>

</table>

{{$users->links()}}

@endsection
