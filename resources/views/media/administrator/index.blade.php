@extends('layouts.administrator.master')
@section('title', 'Medias list')
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
  <button class="uk-button uk-button-small uk-button-secondary " id="uploadBtn">
    <i class="fa fa-plus-circle uk-text-lowercase"> {{ ('Transferer') }}</i>
  </button>
  <button class="uk-button uk-button-small" id="newFolder"><i class="fa fa-folder uk-text-lowercase"> {{ ('Nouveau dossier') }}</i>
  </button>
</div>
  
  <!-- <script type="text/javascript">
    UIkit.util.on('#new-folder', 'click', function (e) {
           e.preventDefault();
           e.target.blur();
           UIkit.modal.dialog(
            '<button class="uk-modal-close-default" type="button" uk-close></button><div class="uk-modal-header">            <h2 class="uk-modal-title"> Création de dossier</h2></div><div class="uk-modal-body"> <form method="post" action="<?php echo route("media.createFolder"); ?>" >  <input type="hidden" name="_token" value="<?php echo csrf_token() ?>" >  <h3> Nouveau dossier</h3>  <label>Nom du dossier :</label>  <input type="text" name="folderName" class="uk-input uk-margin-bottom">  <input type="hidden" name="folderPath" id="folderPath" value="<?php echo $mediaPath;?>">  <button type="submit" name="submit-btn" class="uk-button uk-button-primary"> creer</button> <button type="submit" name="cancel-btn" class="uk-button uk-button-default" >Annuler</button></form></div>');

       });

  </script> -->
<div class="uk-margin-small-top">
<div class="uk-display-inline-block"> {{ ('Affichage') }}</div>
<div class="uk-display-inline-block">
  <ul class="uk-subnav uk-subnav-pill" uk-switcher>
    <li  id="grille" class="display-type">
      <a href="#">
      <i class="fa fa-th"> {{ ('Grille')}}</i>
      </a>
    </li>
   <li  id="liste" class="display-type">
      <a href="#">
      <i class="fa fa-list"> {{ ('Liste')}}</i>
      </a>
    </li>
</ul>
</div>
</div>
<div class="upload-file">
<form method="post" action="{{route('media.upload')}}" class="uk-hidden" enctype="multipart/form-data">
     <input type="hidden" name="_token" value="{{csrf_token()}}" > 
      <label>{{('Parcourir')}}</label>  
  <input type="file" name="uploadedFile" required>
  <input type="hidden" name="path" id="filePath" class="path" value="{{$mediaPath}}">
  <button class="uk-button uk-button-primary uk-button-small"><i class="fa fa-download uk-margin-small-right"></i>{{('Demarrer l\'envoi')}}</button>
       <button type="reset" name="cancelBtn" id="cancelBtn" class="uk-button uk-button-small cancel-btn" >{{('Annuler')}}</button>
     </form>
   </div>
<div class="create-folder-form">
  <form method="post" action="{{route('media.createFolder')}}" class="uk-hidden">
     <input type="hidden" name="_token" value="{{csrf_token()}}" > 
      <label>{{('Nom du dossier :')}}</label>  
      <input type="text" name="folderName" class="" required> 
       <input type="hidden" name="folderPath" id="path" class="path" value="{{$mediaPath}}"> 
       <button type="submit" name="submitBtn" class="">{{('Creer')}}</button> 
       <button type="reset" name="cancelBtn" id="cancelBtn" class="cancel-btn" >{{('Annuler')}}</button>
     </form>
   </div>
<div class="rename-folder-form">
  <form method="post" action="{{route('media.rename')}}" class="uk-hidden">
     <input type="hidden" name="_token" value="{{csrf_token()}}" > 
      <label>{{('Renommer en :')}}</label>  
      <input type="text" name="newName" class="" required> 
       <input type="hidden" name="folderPath" id="path" class="path" value="{{$mediaPath}}"> 
       <input type="hidden" name="oldName" id="oldName" class="oldName" value="">
       <button type="submit" name="submitBtn" class="">{{('Renommer')}}</button> 
       <button type="reset" name="cancelBtn" id="cancelBtn" class="cancel-btn" >{{('Annuler')}}</button>
     </form>
   </div>


<div>
 <div class="racine uk-margin-small-bottom"> <i class="fa fa-folder-open uk-text-muted"> {{ 'Racine : '.$mediaPath}}</i></div>

<div id="media-container" class="media-container uk-grid" >
@foreach($directories as $d)
<div class="folder media" id="{{str_replace('/', '@',$d) }}"> 
<img  class="image-icon" src="{{asset('storage/images/icons/folder-icon.png') }}">
<div class="media-name"> {{str_limit(basename($d),8) }}</div>
</div>
@endforeach
@foreach($files as $f)

<div class="media files" id="{{str_replace('/', '@',$f) }}">
 <img class="image-icon" src="{{asset('storage/'.substr($f, 7)) }}" width="45px">
<div class="media-name">{{ str_limit(basename($f),8) }} </div>
</div>
@endforeach
</div>
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
$(document).ready(function() {

$('.path').val('<?php echo $mediaPath;?>');
$('#newFolder').on('click', function(){
  $('.create-folder-form > form').attr('class','')
});

$('#uploadBtn').on('click', function(){
  $('.upload-file > form').attr('class','')
});

$('.cancel-btn').on('click', function(){
  $('.create-folder-form > form , .upload-file > form , .rename-folder-form > form').attr('class','uk-hidden');

});
});
  </script>
 

@endsection


@endsection
