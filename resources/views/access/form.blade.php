@extends('index')

@section('content')

<div class="container-access">
    <div class="access">
        <div class="access-head">
            <h3>ROOM 911 - Authentication</h3>
        </div>
        @if($action == 'access')
        <form action="{{ url('access') }}" method="POST" class="log">
        @else
        <form action="{{ url('login') }}" method="POST" class="log">
        @endif
        @csrf
            <div class="access-body">
                @if($action == 'access')
                <input type="number" name="identification" placeholder="Id">
                @error('identification') <p> {{ $message }} </p> @enderror
                @else
                @if(session('error'))
                    <p>{{ session('error') }}</p>
                @endif
                <input type="text" name="username" placeholder="User" required value="{{ old('username') }}">
                @error('username') <p> {{ $message }} </p> @enderror
            
                <input type="password" name="password" placeholder="Password" required>
                @error('password') <p> {{ $message }} </p> @enderror
                @endif
            </div>
            <div class="access-footer">
            <button type="submit">
            @if($action == 'access') Access @else Login @endif
            </button>
            </div>
        <form>
    </div>
</div>


@endsection
