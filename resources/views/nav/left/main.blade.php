<nav class="navbar navbar-default navbar-fixed-side">
    <div class="container-fluid">
        <div class="collapse navbar-collapse border-top-none" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                @if(Auth::user()->hasRole())
                    @include('nav.left.partners')
                @endif
                    
                {{--@include('nav.left.schedules')--}}
                @include('nav.left.documents')
                {{--@include('nav.left.users')--}}
                {{--@include('nav.left.reports')--}}
    
    
                @if( ! Auth::user()->hasRole())
                    @include('nav.left.pd-partners')
                @endif
            </ul>
        </div>
    </div>
</nav>