<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700" rel="stylesheet"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.35/css/uikit.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.uikit.min.css">
	<link rel="stylesheet" href="{{asset('css/uikit.css')}}" />
	<link rel="stylesheet" href="{{asset('css/app.css')}}">
       
	@yield('css')
    <link rel="stylesheet" type="text/css" href="">
    <script src="{{asset('js/uikit.min.js')}}"></script>
    <script src="{{asset('js/uikit-icons.js')}}"></script> 
    <title>@yield('title')</title>
</head>

{{-- body --}}
<body>

{{-- hearder --}}
 @component('layouts.administrator.header') @endcomponent 

{{-- main --}}
 @component('layouts.administrator.main') @endcomponent 

{{-- footer --}}
@component('layouts.administrator.footer') @endcomponent 

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.uikit.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
    $('#dataTable').DataTable();
    $('#dataTable_filter label input').addClass('uk-input' );
    $('#dataTable_length label select').addClass('uk-select');
  });
;</script>

@yield('js')

</body>
</html>