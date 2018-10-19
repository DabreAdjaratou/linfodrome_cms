@extends('layouts.administrator.master')
@section('title', 'Billets list')
@section('css')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
 <link rel="stylesheet"  type="text/css" href="{{asset('css/context-menu.min.css')}}">

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
<script src="{{asset('js/context-menu.min.js')}}" ></script>

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

var myMenu = [{

    // Menu Icon. 
    // This example uses Font Awesome Iconic Font.
    icon: 'fa fa-home',   

    // Menu Label
    label: 'Homepage', 

    // Callback
    action: function(option, contextMenuIndex, optionIndex) {}, 

    // An array of submenu objects
    submenu: null,

    // is disabled?
    disabled: false   //Disabled status of the option
},
  {
    icon: 'fa fa-cut', 
    label: 'Couper',  
    action: function(option, contextMenuIndex, optionIndex) {}, 
    submenu: null, 
    disabled: false 
  },
  {
    icon: 'fa fa-envelope', 
    label: 'Contact', 
    action: function(option, contextMenuIndex, optionIndex) {},
    submenu: null,  
    disabled: false  
  },
  {
    //Menu separator
    separator: true   
  },
  {
    icon: 'fa fa-share', 
    label: 'Social Share', 
    action: function(option, contextMenuIndex, optionIndex) {},
    submenu: [{ // sub menus
      icon: 'fa fa-facebook',  
      label: '<a href="https://www.jqueryscript.net/tags.php?/Facebook/">Facebook</a>',  
      action: function(option, contextMenuIndex, optionIndex) {}, 
      submenu: null,  
      disabled: false  
    },
    {
      icon: 'fa fa-<a href="https://www.jqueryscript.net/tags.php?/twitter/">twitter</a>',  
      label: 'Twitter', 
      action: function(option, contextMenuIndex, optionIndex) {}, 
      submenu: null,  
      disabled: false  
    },
    {
      icon: 'fa fa-google-plus',
      label: 'Google Plus',  
      action: function(option, contextMenuIndex, optionIndex) {}, 
      submenu: null,  
      disabled: false  
    }], 
    disabled: false
  },
];

$('.folder').on('contextmenu', function(e) {
  e.preventDefault();
  superCm.createMenu(myMenu, e);
});
</script>


@endsection

@endsection
