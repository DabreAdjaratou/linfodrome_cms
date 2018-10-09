@php
$media=array_last(explode('/', url()->current()));
$mediaPath=str_replace('@','/',$media);
$directories=Storage::directories($mediaPath);
// dd($directories);
$files=Storage::files($mediaPath);
@endphp
@foreach($directories as $d)
<li class="uk-display-inline-block folder" id="{{str_replace('/', '@',$d) }}"> <img src="{{asset('storage/images/icons/folder-icon.png') }}">
<div> {{str_limit(basename($d),8) }}</div>
</li>

@endforeach

@foreach($files as $f)

<li class="uk-display-inline-block " id="{{str_replace('/', '@',$f) }}"> <img src="{{asset('storage/'.substr($f, 7)) }}" width="45px">
<div>{{ str_limit(basename($f),8) }} </div>
</li>

@endforeach
 <script >
 	$(document).ready(function(){
   $(".folder").click(function(){
      var mediaId=$.trim($(this).attr('id')); 
        $.get("{{route('media-to-load',['media'=>'folder'])}}".replace('folder',mediaId), function(data, status){
            $('#txtHint').html(data);
        });
    });
});
 	
 </script>