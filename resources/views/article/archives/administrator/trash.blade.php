@extends('layouts.administrator.master')
@section('title', 'Articles trash')
@section('css')
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('content')
@section ('pageTitle')
<input type="hidden" name="order" id="order" value="desc">
<input type="hidden" name="page" id="page" value="trash">

@parent
<h3>  {{ ('Liste des articles en corbeille') }}</h3> @endsection
@include('article.archives.administrator.filterFields')
<div id="tableContainer">	
@include('article.archives.administrator.searchAndSort',['actions'=>$actions]) 
</div>
@section('sidebar')
 @component('layouts.administrator.article-sidebar') @endcomponent 
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
  $(document).ready(function() {

$('#dataTable').DataTable({
  "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false,
        responsive: true
});
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
      var page=$('#page').val();


      var data= '{"entries":"'+ entries + '","searchByTitle":"'+ searchByTitle + '","searchByCategory":"'+ searchByCategory + '","searchByFeaturedState":'+ searchByFeaturedState + ',"searchByPublishedState":'+ searchByPublishedState + ',"searchByUser":"'+ searchByUser + '","sortField":"'+ sortField+'","order":"'+ order+'","fromDate":"'+ fromDate+'","toDate":"'+ toDate+'","page":"'+ page+'"}'; 
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '{{route('article-archives.search-and-sort')}}',
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

function tableSort (){

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
  };tableSort();
    $("#searchByUser").select2();

    $( ".datepicker" ).datepicker(
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
