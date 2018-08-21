<li class="headline">
    <a>
        <span class="{{ config('app.icon') }} icon" ></span>
        <small>
            @if(isset($tenant))
            {{ $tenant->name }}
            @else
           {{ auth()->user()->name }}
            @endif
            </small>
	</a>
</li>