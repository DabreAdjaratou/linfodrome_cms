  <ul>
    <li>
  {{ basename($directory) }}
   @if(Storage::directories($directory))
@php 
$subDirectories=Storage::directories($directory);
@endphp
@foreach ($subDirectories as $s) 
  @if ( Storage::directories($s)) 
     @include('media.administrator.media-child',['directory'=>$s])
  @else 
{{-- <ul><li>.{{ basename($s)}}.<ul><li>nnn</li></ul></li></ul>'; --}}
  ddd
  @endif
@endforeach
   @endif
 </li>
</ul>