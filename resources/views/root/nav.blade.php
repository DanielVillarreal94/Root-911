<nav>
    <h1>ROOT-911</h1>
    <ul>
        @auth
        <form  style="display: inline;" action="{{ url('logout')}}" method="post">
            @csrf
            <li><a href="#"
                onclick="this.closest('form').submit()"
                >Logout</a></li>
        </form>
        {{-- <li><a href="{{ url('user')}}">Users</a></li> --}}
        @if(auth()->user())
        <li style="color:white;">{{auth()->user()->firstname}}</li>
        @endif
        @else
        <li><a href="{{ url('access_form')}}">Access</a></li>
        <li><a href="{{ url('login_form')}}">Login</a></li>
        @endauth
    </ul>
</nav>
