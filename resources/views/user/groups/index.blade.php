@extends('layouts.administrator.master')
@section('title', 'Groups list')
@section('css')
@endsection
@section('content')
@parent
@section ('pageTitle')<h3>{{ ('Liste des groupes') }}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-divider uk-table-small" {{--uk-text-small responsive --}} >	
<thead>
	<tr>
            <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
		<th>{{ ('Titre') }}</th>
                <th>{{ ('id') }}</th>
	</tr>
	</thead>
<tbody>

@foreach($groups as $group)
<tr>
    <td><input type="checkbox" name="" class="uk-checkbox"></td>
		<td>{{ '-'.$group->title }}</td>
                <td> {{$group->id }}</td> </tr>
                    @foreach($group->getChildrens as $child)
<tr>
    <td><input type="checkbox" name="" class="uk-checkbox"></td>
    <td>{{'--'.ucfirst($child->title)}}</td>
    <td>{{$child->id}}</td> </tr>
    @foreach($child->getChildrens as $child2)
    <tr>
        <td><input type="checkbox" name="" class="uk-checkbox"></td>
    <td>{{'----'.ucfirst($child2->title)}}</td>
    <td>{{$child2->id}}</td>
    </tr>
     @foreach($child2->getChildrens as $child3)
    <tr>
        <td><input type="checkbox" name="" class="uk-checkbox"></td>
    <td>{{'------'.ucfirst($child3->title)}}</td>
    <td>{{$child3->id}}</td>
    </tr>
     @foreach($child3->getChildrens as $child4)
    <tr>
        <td><input type="checkbox" name="" class="uk-checkbox"></td>
    <td>{{'--------'.ucfirst($child4->title)}}</td>
    <td>{{$child4->id}}</td>
    </tr>
    @foreach($child4->getChildrens as $child5)
    <tr>
        <td><input type="checkbox" name="" class="uk-checkbox"></td>
    <td>{{'-----------'.ucfirst($child5->title)}}</td>
    <td>{{$child5->id}}</td>
    </tr>
    @endforeach
     @endforeach
     @endforeach
     @endforeach
           @endforeach
   	
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
