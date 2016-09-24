<ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            {{ Auth::user()->name }} <span class="caret"></span>
        </a>
        
        <ul class="dropdown-menu" role="menu">
            {{--Laravel 5.2--}}
            {{--<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>--}}
            <li><a href="/users/{{ Auth::user()->id }}/edit" class="btn btn-default">My Account</a></li>

            <li>
                <form action="{{ url('/logout') }}" method="POST">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-default form-control">
                        <i class="fa fa-btn fa-sign-out"></i>Logout
                    </button>
                </form>
            </li>
            {{--<a class="btn"> currently used for uniforimty with the form style--}}
        </ul>
    </li>
</ul>