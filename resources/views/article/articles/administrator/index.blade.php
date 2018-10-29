

@extends('layouts.administrator.master')
@section('title', 'Articles list')
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">

@endsection
@section('content')
@section ('pageTitle')
@parent

<div id='tableContainer'>
<h3>  {{ ('Liste des articles') }}</h3> @endsection
<a href="{{ route('articles.create') }}">Nouveau</a> 

  <label> Affiché </label>
  <select id=entries name="entries" class="searchValue"> 
  @for($i=0; $i<sizeof($entries);$i++)
<option value="{{ $entries[$i] }}" @if($entries[$i] == $articles->perPage())  selected @endif>{{ $entries[$i] }}</option>
  @endfor
</select> <label> lignes</label>


<div class="uk-float-left">
<input type="text" name="globalsearch" id="globalSearch" class="searchValue">
<select name="searchByCategory" id="searchByCategory" class="searchValue">
        <option value="">-- Categorie --</option>
    @foreach($categories as $category)
    <option value="{{$category->id}}" @if(isset($searchByCategory) && $category->id==$searchByCategory) selected @endif>{{$category->title}}</option>
    @endforeach
</select>
<select name="searchByFeaturedState" id="searchByFeaturedState" class="searchValue">
    <option value="">-- Vedette --</option>
    <option value="0" @if(isset($searchByFeaturedState) && $searchByFeaturedState==0) selected @endif>Pas à la une</option>
    <option value="1" @if(isset($searchByFeaturedState) && $searchByFeaturedState==1) selected @endif>A la une</option>
</select>

<select name="searchByPublishedState" id="searchByPublishedState" class="searchValue">
    <option value="">-- Etat de publication --</option>
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
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-justify uk-text-small responsive" >	
	<thead>
            <tr>
			<th id='title' class="tableSort">{{ ('Titre') }} <i class="fas fa-caret-up"></i></th>
			<th id="featured" class="tableSort">{{ ('A la une') }}<i class="fas fa-caret-up"></i></i></th>
			<th id="published" class="tableSort">{{ ('Publiée') }}<i class="fas fa-caret-up"></i></i></th>
			<th>{{ ('Category') }}</th>
			<th>{{ ('Auteur') }}</th>
			<th id="created_at" class="tableSort">{{ ('créé le') }}<i class="fas fa-caret-up"></i></i></th>
			<th >{{ ('Dernière modification') }}</i></th>
			<th>{{ ('Modifié le') }}</i></th>
			<th id="views" class="tableSort">{{ ('Nbre de vue') }}<i class="fas fa-caret-up"></i></i></th>
			<th>{{ ('Image') }}</th>
			<th>{{ ('Modifier') }}</th>
      <th>{{ ('brouillon') }}</th>
			<th>{{ ('Corbeille') }}</th>
			<th>{{ ('id') }}</th>                       
		</tr>
	</thead>
	<tbody>
        @foreach($articles as $article)
        <tr class="uk-text-small">
            {{-- <td ><input type="checkbox" name="" class="uk-checkbox"></td> --}}
            <td class="uk-table-expand"> {{ $article->title }}</td>
            <td> {{ $article->featured }}</td>
            <td> {{ $article->published }}</td>
            <td class="uk-table-expand"> {{ $article->getCategory->title }}</td>
            <td class="uk-table-expand"> {{ $article->getAuthor->name }}</td>
           <td class="uk-table-expand"> {{ $article->created_at }}</td>
            <td class="uk-table-expand">{{$article->getRevision->last()['getModifier']['name']}} </td>
            <td class="uk-table-expand">{{$article->getRevision->last()['revised_at']}}  </td>
            <td> {{ $article->views }}</td>
            <td> {{ $article->image }}</td>
            <td> <a href="{{ route('article-archives.edit',['article'=>$article]) }}" ><span class="uk-text-success">Modifier</span></a>
            </td>
                        <td> <a href="{{ route('articles.put-in-draft',['article'=>$article]) }}" ><span class="uk-text-success">Mettre au brouillon</span></a>
            </td>
             <td> <a href="{{ route('article-archives.put-in-trash',['article'=>$article]) }}" ><span class="uk-text-danger">Mettre en corbeille</span></a>
            </td>
            <td>{{ $article->id }}</td>
                </tr>
        @endforeach
   </tbody>
    <tfoot>
    </tfoot>

</table>
    </div>
</div>
<p>  {{ $tableInfo}} </p>
{{ $articles->links() }}
@section('sidebar')
 @component('layouts.administrator.article-sidebar') @endcomponent 
@push('js')
 <script src="http://malsup.github.com/jquery.form.js"></script> 
 

<script type="text/javascript">
$(document).ready(function() {
$('.searchValue').on('change',function(e){
e.preventDefault();
$sortField="";
searchAndSort($sortField);        
       
});

$('.tableSort').on('click',function(e){
  e.preventDefault();
var sortField=e.target.id;
$("#"+ sortField +" i" ).toggleClass('fas fa-caret-up');
searchAndSort(sortField);        

});

function searchAndSort(sortField){
var entries=$('#entries').val();
var globalSearch=$('#globalSearch').val();
var searchByCategory=$('#searchByCategory').val();
var searchByFeaturedState=$('#searchByFeaturedState').val();
var searchByPublishedState=$('#searchByPublishedState').val();
var searchByUser=$('#searchByUser').val();


var data= '{"entries":"'+ entries + '","globalSearch":"'+ globalSearch + '","searchByCategory":"'+ searchByCategory + '","searchByFeaturedState":"'+ searchByFeaturedState + '","searchByPublishedState":"'+ searchByPublishedState + '","searchByUser":"'+ searchByUser + '","sortField":"'+ sortField+'"}'; 
               $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '{{route('articles.list')}}',
          dataType : 'html',
          type: 'POST',
          data: data,
          contentType: false, 
          processData: false,
          success:function(response) {
              $('#tableContainer').html(response);
          }
     });   
}




});
</script>
@endpush
 <!--$("#tableContainer").load("{{route('articles.list')}}");-->
@endsection

@section('js')

@endsection

@endsection
