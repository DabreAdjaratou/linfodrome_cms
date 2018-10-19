<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700" rel="stylesheet"> 
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.uikit.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="{{asset('css/uikit.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
       
	@yield('css')
    <link rel="stylesheet" type="text/css" href="">
    <script src="{{asset('js/uikit.min.js')}}"></script>
    <script src="{{asset('js/uikit-icons.js')}}"></script> 
    <title>{{ ('Administration') }} - @yield('title')</title>
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
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
@stack('js')
@yield('js')

</body>
</html>