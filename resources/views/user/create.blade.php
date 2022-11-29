@extends('index')

@section('content')
    <form action="{{ url('/user/') }}" method="POST">
        @csrf
        @include('user.form', ['state'=>'Create'])
    </form>
@endsection