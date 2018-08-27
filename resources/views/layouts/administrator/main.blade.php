<div class="uk-container uk-container-large">
	@yield('pageTitle')
	@if ($errors->any())
    <div class="">  {{-- alerte --}}
        <ul>
            @foreach ($errors->all() as $error)
            <li class="uk-alert uk-alert-danger">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="uk-grid uk-margin-top">
    
    <div class="uk-width-1-6 ">
          @yield('sidebar')
    
</div>
    
    <div class="uk-width-5-6">
    
    @yield('content')
    
</div>      
    
</div>

	
</div>	
