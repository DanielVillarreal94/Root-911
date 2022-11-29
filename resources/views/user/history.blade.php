@extends('index')
@section('content')
<div class="container-body">
    <div class="filters">
        <form action="{{ url('/filter_history/') }}" method="POST" style="margin-top: 0px !important;">
            @csrf
            <div class="margin-left-xs">
                <label for="">Final access date:</label>
                <br>
                <input type="date" name="initial">
            </div>
            <div class="margin-left-xs">
                <label for="">Initial access date:</label>
                <br>
                <input type="date" name="final">
            </div>
            <input type="hidden" name="identification" value="{{$identification}}">
            <input type="hidden" name="clean" id="clean" value="">
            <div><br><button type="submit"  class="filter">Filter</button></div>
            <div><br><button type="submit" id="clearFilter"  class="filter">Clear filter</button></div>
        </form>
    </div>
    <hr>
    <div class="section-body">
        <div class="section-body-header">
            <a href="{{ url('user_pdf/'. $identification) }}" class="right" title="Export pdf"><img src="{{ asset('img/pdf.png') }}"></a>
        </div>
        <div class="section-body-content">
            <table class="table">
                <thead>
                    <tr>
                        <th>Employee Id</th>
                        <th>Fullname</th>
                        <th>Department</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($history as $user)
                    <tr>
                        <td>{{ $user->identification}}</td>
                        <td>{{ $user->firstname }} {{ $user->lastname}}</td>
                        <td>{{ $user->name}}</td>
                        <td>{{ $user->date}}</td>
                        <td>{{ $user->time}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="section-body-footer">
            <a class="button-second left" href="{{ url('user') }}">Back</a>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script type="text/javascript">
    $('#clearFilter').click(function () {
        $('#clean').val(1)
    });
</script>
@endsection