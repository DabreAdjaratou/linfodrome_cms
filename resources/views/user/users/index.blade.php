@extends('layouts.administrator.master')
@section('title', 'Users list')
@section('css')
@endsection
@section('content')
@parent
@section ('pageTitle')<h3>{{ ('Liste des utilisateurs') }}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-striped uk-table-small responsive">	
    <thead>
       <tr>
        <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
        <th>{{ ('Nom') }}</th>
        <th>{{ ('Email') }}</th>
        <th>{{ ('titre') }} </th>
        <th>{{ ('Facebook') }}</th>
        <th>{{ ('Google') }}</th>
        <th>{{ ('twitter') }}</th>
        <th>{{ ('Actif') }}</th>
        <th>{{ ('id') }}</th>

    </tr>
    

</thead>
<tbody>

    @foreach($users as $user)
    <tr>
        <td><input type="checkbox" name="" class="uk-checkbox"></td>
        <td class="uk-table-expand">{{ $user->name}}
            
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
@endsection
