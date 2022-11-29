<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pdf</title>
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}" />
</head>
<body>
    <div class="section-body">
        <div class="section-body-header">
            <h1 style="text-align: center;">ROOT-9411</h1>
            <h2>Historial de usuario: {{$history[0]->firstname}} {{$history[0]->lastname}}</h2>
            <h4>Departamento: {{$history[0]->department->name}}</h4>
        </div>
        <div class="section-body-content">
            <table class="table">
                <thead>
                    <tr>
                        <th>Employee Id</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($history as $user)
                    <tr>
                        <td>{{ $user->identification}}</td>
                        <td>{{ $user->date}}</td>
                        <td>{{ $user->time}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
