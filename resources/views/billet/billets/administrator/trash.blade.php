@extends('layouts.administrator.master')
@section('title', 'Billets trash')
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('content')
@section ('pageTitle')
<input type="hidden" name="order" id="order" value="desc">
<input type="hidden" name="itemType" id="itemType" value="billet-trash">
@parent
  <h3>  {{ ('Liste des billets en corbeille') }}</h3> @endsection 
  @include('billet.billets.administrator.filterFields')
  <div id='tableContainer'>
   @include('billet.billets.administrator.searchAndSort',['actions'=>$actions]) 
</div>
@section('sidebar')
@component('layouts.administrator.billet-sidebar') @endcomponent 
@endsection
@routes
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{{ asset('js/own-datatable.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/custom-datepicker.js') }}"></script>
@endpush

@endsection
