@php
$media=array_last(explode('/', url()->current()));
$mediaPath=str_replace('@','/',$media);
$directories=Storage::directories($mediaPath);
// dd($directories);
$files=Storage::files($mediaPath);
@endphp
@foreach($directories as $d)
<div class="folder media" id="{{str_replace('/', '@',$d) }}"> <img class="imageIcon" src="{{asset('storage/images/icons/folder-icon.png') }}">
<div> {{str_limit(basename($d),8) }}</div>
</div>

@endforeach

@foreach($files as $f)

<div class="media mediaContainer" id="{{str_replace('/', '@',$f) }}"> <img class="imageIcon" src="{{asset('storage/'.substr($f, 7)) }}" width="45px">
<div>{{ str_limit(basename($f),8) }} </div>
</div>

@endforeach
<script src="{{ asset('js/media.js') }}"></script>
<script src="{{ asset('js/custom-menu-context.js') }}"></script>
