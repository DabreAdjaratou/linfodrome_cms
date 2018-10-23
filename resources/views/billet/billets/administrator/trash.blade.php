@extends('layouts.administrator.master')
@section('title', 'Billets trash')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des billets en corbeille') }}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small uk-text-small responsive uk-table-justify responsive" >	
	<thead>
            <tr>
            <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
			<th>{{ ('Titre') }}</th>
			<th>{{ ('A la une') }}</th>
			<th>{{ ('Publié') }}</th>
			<th>{{ ('Category') }}</th>
			<th>{{ ('Auteur') }}</th>
			<th>{{ ('créé le') }}</th>
			<th>{{ ('Dernière modification') }}</th>
			<th>{{ ('Modifié le') }}</th>
			<th>{{ ('Nbre de vue') }}</th>
			<th>{{ ('Image') }}</th>
                        <th>{{ ('Restaurer') }}</th>
                        <th>{{ ('Suprrimer') }}</th>
			<th>{{ ('id') }}</th>                       
		</tr>
	</thead>
	<tbody>
		@foreach($billets as $billet)
		<tr class="uk-text-small">
			<td ><input type="checkbox" name="" class="uk-checkbox"></td>
			<td class="uk-table-expand"> {{ $billet->title }}</td>
			<td> {{ $billet->featured }}</td>
			<td> {{ $billet->published }}</td>
			<td class="uk-table-expand"> {{ $billet->getCategory->title }}</td>
			<td class="uk-table-expand"> {{ $billet->getAuthor->name }}</td>
			<td class="uk-table-expand"> {{ $billet->created_at }}</td>
			<td class="uk-table-expand">{{$billet->getRevision->last()['getModifier']['name']}} </td>
			<td class="uk-table-expand">{{$billet->getRevision->last()['revised_at']}}  </td>
			<td> {{ $billet->views }}</td>
			<td> {{ $billet->image }}</td>
                        <td> <a href="{{ route('billets.restore',['billet'=>$billet]) }}" ><span class="uk-text-success">Restaurer</span></a>

			</td>
			
			<td> <form action="{{ route('billets.destroy',['billet'=>$billet]) }}" method="POST" id="deleteForm" onsubmit="return confirm('Êtes vous sûre de bien vouloir supprimer ce billet?')">
				@csrf
				@method('delete')
<button class="uk-button uk-button-link"><span class="uk-text-danger">Supprimer</span></button>
			</form> 
			</td>
			<td>{{ $billet->id }}</td>
                </tr>
		@endforeach
	</tbody>
	<tfoot>
	</tfoot>
</table>
@section('sidebar')
 @component('layouts.administrator.billet-sidebar') @endcomponent 
@endsection
@section('js')
<script type="text/javascript" src="{{asset('js/custom-datatable.js')}}" ></script>
@endsection

@endsection