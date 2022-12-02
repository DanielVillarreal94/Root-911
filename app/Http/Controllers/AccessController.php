<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\User;
use Illuminate\Http\Request;

class AccessController extends Controller
{
    public function accessForm()
    {
        $action['action'] = 'access';
        return view('access.form', $action);
    }

    public function save(Request $request)
    {
        $request->validate([
            'identification' => ['required'],
        ]);
        $action['action'] = 'access';
        $user = User::find($request->identification);
        $message['message'] = '';
        if ($user && $user->state == 1 && $user->role_id == 3) {
            $action['message'] = 'Acceso permitido';
        }else if ($user && $user->role_id != 3) {
            $action['message'] = 'Acceso denegado... Rol no permitido';
        }else if ($user && $user->state == 0) {
            $action['message'] = 'Acceso denegado... Permisos insuficientes';
        }else{
            $action['message'] = 'Acceso denegado... No hay registro con esa identificación';
        }
        $access = new Record();
        $access->access_date =  now();
        $access->id = $request->identification;
        $access->save();
        return view('access.form', $action, $message);
    }

}
