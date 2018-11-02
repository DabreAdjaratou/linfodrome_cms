@extends('layouts.administrator.master')
@section('title', 'Videos list')
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
@section ('pageTitle')
<input type="hidden" name="order" id="order" value="desc">
@parent
<div id='tableContainer'>
<h3>  {{ ('Liste des videos') }}</h3> @endsection 
<a href="{{ route('videos.create') }}">Nouveau</a> 
 <label> Affiché </label>
  <select id=entries name="entries" class="searchValue"> 
  @for($i=0; $i<sizeof($entries);$i++)
<option value="{{ $entries[$i] }}" @if($entries[$i] == $videos->perPage())  selected @endif>{{ $entries[$i] }}</option>
  @endfor
</select> <label> lignes</label>


<div>
    <input type="text" name="searchByTitle" id="searchByTitle" class="searchValue" @if(isset($searchByTitle)) value="{{$searchByTitle}}" @endif><button  id="searchByTitleButton" name="searchByTitleButton">chercher</button>
<select name="searchByCategory" id="searchByCategory" class="searchValue">
        <option value="">-- Categorie --</option>
    @foreach($categories as $category)
    <option value="{{$category->id}}" @if(isset($searchByCategory) && $category->id==$searchByCategory) selected @endif>{{$category->title}}</option>
    @endforeach
</select>
<select name="searchByFeaturedState" id="searchByFeaturedState" class="searchValue">
    <option value="null" >-- Vedette --</option>
    <option value="0" @if(isset($searchByFeaturedState) && $searchByFeaturedState==0) selected @endif>Pas à la une</option>
    <option value="1" @if(isset($searchByFeaturedState) && $searchByFeaturedState==1) selected @endif>A la une</option>
</select>

<select name="searchByPublishedState" id="searchByPublishedState" class="searchValue">
    <option value="null">-- Etat de publication --</option>
    <option value="0" @if(isset($searchByPublishedState) && $searchByPublishedState==0) selected @endif>Non publié</option>
    <option value="1" @if(isset($searchByPublishedState) && $searchByPublishedState==1) selected @endif>Publié</option>
</select>

<select name="searchByUser" id="searchByUser" class="searchValue">
    <option value="">-- User --</option>
@foreach($users as $user)
<option value="{{$user->id}}" @if(isset($searchByUser) && $user->id==$searchByUser) selected @endif>{{$user->name}}</option>
    @endforeach
    </select>

</div>
<div>
<table id="dataTable" class="uk-table-hover uk-table-striped uk-table-small uk-table-justify uk-text-small responsive">	
	<thead>
            <tr>
			<th id="title" class="tableSort">{{ ('Titre') }}<i class="fas fa-sort"></th>
			<th id="category_id" class="tableSort">{{ ('Categorie') }}<i class="fas fa-sort"></th>
			<th id="featured" class="tableSort">{{ ('A la Une') }}<i class="fas fa-sort"></th>
			<th id="published" class="tableSort">{{ ('Publiée') }}<i class="fas fa-sort"></th>
			<th>{{ ('Journaliste') }}</th>
			<th>{{ ('Cameraman') }}</th>
			<th>{{ ('Monteur') }}</th>
			<th id="created_at" class="tableSort">{{ ('crée lé') }}<i class="fas fa-sort"></th>
			<th>{{ ('Debut publication') }}</th>
			<th>{{ ('fin publication') }}</th>
			<th id="views" class="tableSort">{{ ('Nbre de vue') }}<i class="fas fa-sort"></th>
                        <th>{{ ('Modifier') }}</th>
                        <th>{{ ('Brouillon') }}</th>
                        <th>{{ ('Corbeille') }}</th>
			<th>{{ ('id') }}</th>
                       
		</tr>
	</thead>
	<tbody>		
		@foreach($videos as $video)		
		<tr>
            <td class="uk-table-expand"> {{ ucfirst($video->title) }}</td>
			<td class="uk-table-expand"> {{$video->getCategory->title}}</td>
			<td> {{ $video->featured }}</td>
			<td> {{ $video->published }}</td>
			<td class="uk-table-expand"> {{ucwords($video->getAuthor->name)}}</td>
			<td class="uk-table-expand"> {{ucwords($video->getCameraman->name)}}</td>
			<td class="uk-table-expand"> {{ucwords($video->getEditor->name)}}  </td>
			<td class="uk-table-expand">{{$video->created_at}}</td>
			<td class="uk-table-expand">{{ $video->start_publication_at}} </td>
			<td class="uk-table-expand"> {{$video->stop_publication_at}}</td>
			<td> {{$video->views}}</td>
                        <td> <a href="{{ route('videos.edit',['video'=>$video]) }}" ><span class="uk-text-success">Modifier</span></a>

			</td>
                        <td> <a href="{{ route('videos.put-in-draft',['video'=>$video]) }}" ><span class="uk-text-success">Mettre au brouillon</span></a>

			</td>
                        <td> <a href="{{ route('videos.put-in-trash',['video'=>$video]) }}" ><span class="uk-text-danger">Mettre en corbeille</span></a>

			</td>
			<td>{{ $video->id }}</td>
                </tr>
		@endforeach
	</tbody>
	<tfoot>
	</tfoot>
</table>
  </div>
</div>
{{ $tableInfo}}
{{ $videos->links() }}
@section('sidebar')
 @component('layouts.administrator.video-sidebar') @endcomponent 
@endsection
@push('js')
 <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

function searchAndSort(sortField){
var entries=$('#entries').val();
var searchByTitle=$('#searchByTitle').val();
var searchByCategory=$('#searchByCategory').val();
var searchByFeaturedState=$('#searchByFeaturedState').val();
var searchByPublishedState=$('#searchByPublishedState').val();
var searchByUser=$('#searchByUser').val();
var order=$('#order').val();


var data= '{"entries":"'+ entries + '","searchByTitle":"'+ searchByTitle + '","searchByCategory":"'+ searchByCategory + '","searchByFeaturedState":'+ searchByFeaturedState + ',"searchByPublishedState":'+ searchByPublishedState + ',"searchByUser":"'+ searchByUser + '","sortField":"'+ sortField+'","order":"'+ order+'"}'; 
               $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '{{route('videos.search-and-sort')}}',
          dataType : 'html',
          type: 'POST',
          data: data,
          contentType: false, 
          processData: false,
          success:function(response) {
              $('#tableContainer').html(response);
          }
     });   

};

$('.searchValue').on('change',function(e){
e.preventDefault();
searchAndSort(sortField='id');        
       
});

$('#searchByTitleButton').on('click',function(e){
e.preventDefault();
searchAndSort(sortField='id');        
       
});

$('.tableSort').on('click',function(e){
  e.preventDefault();
var sortField=e.target.id;
var order=$('#order').val();
searchAndSort(sortField);        
if(order=='asc'){
                $('#order').val('desc')
               }
               if (order=='desc') {
                 $('#order').val('asc')
               }
});
$("#searchByUser").select2();

  });
</script>
@endpush
@section('js')

@endsection

@endsection
