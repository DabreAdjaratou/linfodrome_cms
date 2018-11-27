@extends('layouts.administrator.master')
@section('title', 'Medias list')
@section('css')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
 <link rel="stylesheet"  type="text/css" href="{{asset('css/context-menu.min.css')}}">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 </script>
 @endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Medias') }}</h3> @endsection 
<div>
  <button class="uk-button uk-button-small uk-button-secondary "><i class="fa fa-plus-circle uk-text-lowercase"> {{ ('Transferer') }}</i></button>
  <button class="uk-button uk-button-small"><i class="fa fa-folder uk-text-lowercase"> {{ ('Nouveau dossier') }}</i></button>
  
</div>
<div>
<div> {{ (' Affichage') }}</div>
<div class="uk-margin-bottom">
  <ul class="uk-subnav uk-subnav-pill" uk-switcher>
    <li  id="grille" class="displayType">
      <a href="#">
      <i class="fa fa-th"> Grille</i>
      </a>
    </li>
   <li  id="liste" class="displayType">
      <a href="#">
      <i class="fa fa-list"> Liste</i>
      </a>
    </li>
</ul>
<!-- <button class="uk-button uk-button-small displayType" id="grille"><i class="fa fa-th"> Grille</i></button>
<button class="uk-button uk-button-small displayType" id="liste"><i class="fa fa-list"> Liste</i></button> -->
</div>
</div>

<div id="mediaContainer" class="mediaContainer uk-grid" >
@foreach($directories as $d)
<div class="folder media" id="{{str_replace('/', '@',$d) }}"> 
<img  class="imageIcon" src="{{asset('storage/images/icons/folder-icon.png') }}">
<div> {{str_limit(basename($d),8) }}</div>
</div>

@endforeach
@foreach($files as $f)

<div class="media" {{str_replace('/', '@',$f) }}>
 <img class="imageIcon" src="{{asset('storage/'.substr($f, 7)) }}" width="45px">
<div>{{ str_limit(basename($f),8) }} </div>
</div>
@endforeach
</div>
@section('sidebar')
 @component('layouts.administrator.media-sidebar') @endcomponent 
@endsection
@routes
@section('js')
  {{-- include the jQuery library --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
  {{-- include the minified jstree source --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<script src="{{asset('js/context-menu.min.js')}}" ></script>

<script src="{{ asset('js/custom-jstree.js') }}"></script>
<script src="{{ asset('js/custom-menu-context.js') }}"></script>
<script src="{{ asset('js/media.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>

  </script>
 

@endsection

@endsection
