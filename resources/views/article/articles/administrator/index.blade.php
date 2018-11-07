

@extends('layouts.administrator.master')
@section('title', 'Articles list')
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('content')
@section ('pageTitle')
<input type="hidden" name="order" id="order" value="desc">
@parent
  <h3>  {{ ('Liste des articles') }}</h3> @endsection
  <a href="{{ route('articles.create') }}">Nouveau</a> 

<div>
  <label> Affiché </label>
  <select id=entries name="entries" class="searchValue"> 
    @for($i=0; $i<sizeof($entries);$i++)
    <option value="{{ $entries[$i] }}" @if($entries[$i] == $articles->perPage())  selected @endif>{{ $entries[$i] }}</option>
    @endfor
  </select> <label> lignes</label>
</div>

  <div>
    <input type="text" placeholder="--Titre--" name="searchByTitle" id="searchByTitle" class="searchValue" @if(isset($searchByTitle)) value="{{$searchByTitle}}" @endif autocomplete="off"><button  id="searchButton" name="searchButton">chercher</button>
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
    <div class="uk-display-inline-block">De: <input type="text" class="datepicker" id="fromDate" @if(isset($fromDate)) value='{{ date("d/m/Y", strtotime($fromDate))}}' @endif autocomplete="off"></div>
    <div class="uk-display-inline-block">A: <input type="text" class="datepicker" id="toDate" @if(isset($toDate)) value='{{ date("d/m/Y", strtotime($toDate))}}' @endif autocomplete="off"></div>

  </div>

<div id='tableContainer'>
@include('article.articles.administrator.searchAndSort');
</div>
@section('sidebar')
@component('layouts.administrator.article-sidebar') @endcomponent 
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
      var fromDate=$('#fromDate').val();
      var toDate=$('#toDate').val();

      var data= '{"entries":"'+ entries + '","searchByTitle":"'+ searchByTitle + '","searchByCategory":"'+ searchByCategory + '","searchByFeaturedState":'+ searchByFeaturedState + ',"searchByPublishedState":'+ searchByPublishedState + ',"searchByUser":"'+ searchByUser + '","sortField":"'+ sortField+'","order":"'+ order+'","fromDate":"'+ fromDate+'","toDate":"'+ toDate+'"}'; 
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '{{route('articles.search-and-sort')}}',
        dataType : 'html',
        type: 'POST',
        data: data,
        contentType: false, 
        processData: false,
        success:function(response) {
          $('#tableContainer').html(response);
         tableSort();
        }
      });   

    };

    $('.searchValue').on('change',function(e){
      e.preventDefault();
      searchAndSort(sortField='id');        

    });

    $('#searchButton').on('click',function(e){
      e.preventDefault();
      searchAndSort(sortField='id');        

    });

    function tableSort(){

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
    }; tableSort();

    $("#searchByUser").select2();

    $(".datepicker" ).datepicker(
    {
      monthNames: [ "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Decembre" ],
      monthNamesShort: [ "Jan", "Féb", "Mar", "Avr", "Mai", "Jui", "Juil", "Aoû", "Sep", "Oct", "Nov", "Dec" ],
      dayNames: [ "Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi" ],
      dayNamesMin: [ "Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ],
      dateFormat: "dd/mm/yy",
      nextText: "suivant",
      prevText: "précédent",
      showButtonPanel: true,
      currentText: "Aujourd'hui",
      closeText: "Fermer"

    });


  });

</script>
@endpush

@endsection

@section('js')

@endsection

@endsection
