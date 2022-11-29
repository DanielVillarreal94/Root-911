@extends('index')

@section('content')
    <form action="{{ url('/user/'.$user->identification) }}" method="post">
        @csrf
        {{ method_field('PATCH') }}  
        @include('user.form', ['state'=>'Edit'])     
    </form>
@endsection