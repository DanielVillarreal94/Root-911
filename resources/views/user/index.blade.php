@extends('index')
@section('content')
<div class="container-body">
    <div class="filters">
        <form action="{{ url('/filter/') }}" method="POST" style="margin-top: 0px !important;">
            @csrf
            <input type="text" class="margin-left-xs" name="filter" placeholder="Search by employed Id" value="{{ old('filter') }}">
            <select class="margin-left-xs" name="department_id">
                <option value="" disabled selected>Select role</option>
                @foreach ( $departments as $department )
                <option value="{{$department->id_department}}">{{ $department->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="filter">Filter</button>
            <button type="submit" class="filter">Clear filter</button>
        </form>
    </div>
    <hr>
    <div class="section-body">
        <div class="section-body-header">
            <a class="button right primary a-btn" href="{{ url('user/create') }}">Create</a>
            <form action="{{ url('user_import')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div style="display: flex;">
                    <input type="file" name="document" class="right" style="color: white;" required>
                    <button type="submit" class="import">Import</button>
                </div>
            </form>
        </div>

        <div class="section-body-content">
            <table class="table">
                <thead>
                    <tr>
                        <th>Employee Id</th>
                        <th>Fullname</th>
                        <th>Username</th>
                        <th>Department</th>
                        <th>Role</th>
                        <th>Total access</th>
                        <th>State</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->identification}}</td>
                        <td>{{ $user->firstname }} {{ $user->lastname}}</td>
                        <td>{{ $user->username}}</td>
                        <td>{{ $user->name}}</td>
                        <td>{{ $user->role_name}}</td>
                        <td>{{ $user->total}}</td>
                        <td>
                            <a name="{{$user->identification}}" class="updateState image" id="{{$user->identification}}" style="cursor: pointer;" 
                                @if($user->state==0) title="Enable" @else title="Desable" @endif >
                                @if($user->state==0) 
                                <img src="{{ asset('img/disable.png') }}"> 
                                @else
                                <img src="{{ asset('img/enable.png') }}">
                                @endif 
                            </a>
                        </td>
                        <td>
                            <div style="display: flex; justify-content: space-around;">     
                                <a href="{{ url('/user_history/'.$user->identification)}}" title="History"><img src="{{ asset('img/clock.png') }}"></a>
                                <a href="{{ url('/user/'.$user->identification.'/edit')}}" title="Edit"><img src="{{ asset('img/edit.png') }}"></a>
                                <form id="del" action="{{ url('/user/'.$user->identification) }}" method="POST">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <a href="#" class="delete"  name="{{$user->identification}}">
                                        <img src="{{ asset('img/delete.png') }}" title="Delete">
                                    </a>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="section-body-footer"></div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script type="text/javascript">
    $(".updateState").click(function() {
        var id = $(this).attr('name');
        console.log(id);
        fetch('http://localhost/room_911/public/api/user/'+id)
        .then(response => response.json())
        .then(data => {
            //console.log($(this)[0].innerText);
            var tag = document.getElementById(id);
            if(data.user.state == 1){
                document.getElementById(id).innerHTML = '<img src="img/enable.png">';
                tag.title = "Desable"
            } else {
                document.getElementById(id).innerHTML = '<img src="img/disable.png">';
                tag.title = "Enable"
                
            }
        });
    });

    $(".delete").click(function(){
        var id = $(this).attr('name');
        var res = confirm('¿Decea eliminar el registro: '+id+'?');
        if(res){
            $(this).closest('form').submit();
        }
    });
    
    
</script>
@endsection