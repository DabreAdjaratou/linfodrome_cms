@extends('layouts.administrator.master')
@section('title', 'Billets list')
@section('css')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
 @endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Medias') }}</h3> @endsection 
<div id="txtHint">

@foreach($directories as $d)
<li class="uk-display-inline-block folder" id="{{str_replace('/', '@',$d) }}"> <img src="{{asset('storage/images/icons/folder-icon.png') }}">
<div> {{str_limit(basename($d),8) }}</div>
</li>

@endforeach

@foreach($files as $f)

<li class="uk-display-inline-block" {{str_replace('/', '@',$f) }}> <img src="{{asset('storage/'.substr($f, 7)) }}" width="45px">
<div>{{ str_limit(basename($f),8) }} </div>
</li>
@endforeach
</div>
@section('sidebar')
 @component('layouts.administrator.media-sidebar') @endcomponent 
@endsection

@section('js')
  {{-- include the jQuery library --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
  {{-- include the minified jstree source --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>

<script>
  $(function () {
    // create an instance when the DOM is ready
    $('#jstree').jstree();
    // bind to events triggered on the tree
    $('#jstree').on("changed.jstree", function (e, data) {
      var media=$.parseHTML(data.node.text);
      var mediaId=media[0].id;
      var urlToLoad="{{route('media-to-load',['media'=>'folder'])}}".replace('folder',mediaId);
      // console.log(urlToLoad);
      $.get(urlToLoad, function(data, status){
            $('#txtHint').html(data);
        });
      // console.log(data.selected);

    });

    $(".folder").click(function(){
      var mediaId=$.trim($(this).attr('id')); 
        $.get("{{route('media-to-load',['media'=>'folder'])}}".replace('folder',mediaId), function(data, status){
            $('#txtHint').html(data);
        });
    });
        
});

    
</script>


@endsection

@endsection
