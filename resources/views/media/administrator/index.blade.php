@extends('layouts.administrator.master')
@section('title', 'Billets list')
@section('css')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
 <link rel="stylesheet"  type="text/css" href="{{asset('css/context-menu.min.css')}}">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
<div class="uk-button-group uk-margin-bottom">
<button class="uk-button uk-button-small displayButton" id="grille"><i class="fa fa-th"> Grille</i></button>
<button class="uk-button uk-button-small displayButton" id="liste"><i class="fa fa-list"> Liste</i></button>
</div>
</div>

<div id="mediaContainer" class="mediaContainer uk-grid" >
@foreach($directories as $d)
<div class="folder media" id="{{str_replace('/', '@',$d) }}"> <img src="{{asset('storage/images/icons/folder-icon.png') }}">
<div> {{str_limit(basename($d),8) }}</div>
</div>

@endforeach
@foreach($files as $f)

<div class="media" {{str_replace('/', '@',$f) }}> <img src="{{asset('storage/'.substr($f, 7)) }}" width="45px">
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
<script src="{{ asset('js/media-to-load.js') }}"></script>
<script src="{{ asset('js/custom-menu-context.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
  $('.displayButton').on('click',function(){
var id=$(this).attr('id');
if (id == 'liste'){
$('#mediaContainer').attr('class','mediaContainer');
$('.media > div').attr('class','uk-display-inline');
$('#mediaContainer > div > img').attr('width','15px');

}else{
$('#mediaContainer').attr('class','mediaContainer uk-grid');
$('.media > div').attr('class','');
$('#mediaContainer > div > img').attr('width','45px');

};
  });

  $( function() {
    $( ".uk-button-group" ).selectable();
  } );
</script>

@endsection

@endsection
