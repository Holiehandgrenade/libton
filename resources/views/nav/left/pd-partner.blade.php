<li class="dropdown">
    <a href="{{ url('/partners/' . $pdPartner->id) }}" class="dropdown-toggle">
        {{ $pdPartner->name }}
    </a>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ url('/partners/' . $pdPartner->id) }}">
                Info
            </a>
        </li>
        @if($pdPartner->schedules->count())
            <li>
                <a href="{{ url('/schedules/' . $pdPartner->schedules->first()->id . '/sections') }}">
                    Schedule
                </a>
            </li>
        @endif
        <li>
            <a href="{{ url('/partners/' . $pdPartner->id . '/users') }}">
                Employees
            </a>
        </li>
        <li>
            <a href="{{ url('/partners/' . $pdPartner->id . '/campuses') }}">
                Campuses
            </a>
        </li>
        <li>
            <a href="{{ url('/partners/' . $pdPartner->id . '/moa') }}">
                Agreement
            </a>
        </li>
    </ul>
</li>