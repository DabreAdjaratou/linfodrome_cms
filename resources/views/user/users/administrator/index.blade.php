@extends('layouts.administrator.master')
@section('title', 'Users list')
@section('css')

@endsection
  
@section('content')
@parent
@section ('pageTitle')<h3>{{ ('Liste des utilisateurs') }}</h3> @endsection 
<a href="{{ route('register') }}">Nouveau</a> 
<table id="dataTable" class="uk-table uk-table-striped uk-table-small uk-text-small">	
    <thead>
       <tr>
        <th>{{ ('Nom') }}<i class="fas fa-sort uk-margin-left"></th>
        <th>{{ ('Email') }}</th>
        <th>{{ ('titre') }} <i class="fas fa-sort uk-margin-left"></th>
        <th>{{ ('Facebook') }}</th>
        <th>{{ ('Google') }}</th>
        <th>{{ ('twitter') }}</th>
        <th>{{ ('Actif') }}<i class="fas fa-sort uk-margin-left"></th>
        <th>{{ ('id') }}<i class="fas fa-sort uk-margin-left"></th>

    </tr>
    

</thead>
<tbody>

    @foreach($users as $user)
    <tr>
        <td class="uk-table-expand"><a href="{{ route('users.edit',['user'=>$user]) }}">{{ $user->name}}</a>
            
            @if($user->require_reset==0)
            <div class="uk-text-small uk-alert-danger">{{ ('reinitialisation du mot de passe requis') }}</div>
            @endif
        </td>
        <td class="uk-table-expand">{{ $user->email}}</td>
        <td class="uk-table-expand">{{ $user->data->title}}</td>
        <td class="uk-table-expand uk-text-truncate">{{ $user->data->facebook}}</td>
        <td class="uk-table-expand uk-text-truncate">{{ $user->data->google}}</td>
        <td class="uk-table-expand uk-text-truncate">{{ $user->data->twitter}}</td>
        <td>{!!$user->is_active!!}</td>
        <td>{{ $user->id}}</td>
    </tr>
    @endforeach
</tbody>

<tfoot>
	


</tfoot>

</table>

@section('sidebar')
@component('layouts.administrator.user-sidebar') @endcomponent 
@endsection
@push('js')
<script type="text/javascript">
$(document).ready(function() {
  
$('#dataTable').DataTable({
    "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
    "language": {
            "lengthMenu": "Affiché _MENU_ lignes",
            "zeroRecords": "Aucun donnée correspondant - desolé",
           "info": "Affichage de _START_ à _END_ sur _TOTAL_ entries",
           "infoEmpty": "Affichage de 0 à  0 sur 0 entries",
            "infoEmpty": "Aucun resultat disponible",
            "infoFiltered": "",
            "search":         "Recherche:",

        },
        "columnDefs": [
        { "orderable": false, "targets": [1,3,4,5] },
         { "searchable": false, "targets" : [1,3,4,5] 
                },

  ]
                 }); 

 }); 
</script>
@endpush



@endsection
