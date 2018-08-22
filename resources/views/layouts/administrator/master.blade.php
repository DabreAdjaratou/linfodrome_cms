<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700" rel="stylesheet"> 
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

@yield('js')

</body>
</html>