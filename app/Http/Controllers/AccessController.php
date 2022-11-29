<?php

namespace App\Http\Controllers;

use App\Models\Record;
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
        $access = new Record();
        $access->access_date =  now();
        $access->id = $request->identification;
        $access->save();
        return $this->accessForm();
    }

}
