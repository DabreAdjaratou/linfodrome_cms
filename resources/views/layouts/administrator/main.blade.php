<div class="uk-container uk-container-large">
	@yield('pageTitle')
	@if ($errors->any())
    <div class="">  {{-- alerte --}}
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@yield('content')
	
</div>	
