@extends('layouts.administrator.master')
@section('title', 'Media')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Media') }} </h3>@endsection 

<div id='txtHint'></div>
@section('sidebar')
 @component('layouts.administrator.media-sidebar') @endcomponent 
@endsection
@endsection