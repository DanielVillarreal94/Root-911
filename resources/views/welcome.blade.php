@extends('root.nav')

@section('content')

<div class="container-access">
    <div class="access">
        <div class="access-head">
            <h3>ROOM 911 - Authentication</h3>
        </div>
        <form>
            <div class="access-body">
                <input type="number" name="idAccess" placeholder="Id">
            </div>
            <div class="access-footer">
                <button class="button">Access</button>
            </div>
        <form>
    </div>
</div>


@endsection
