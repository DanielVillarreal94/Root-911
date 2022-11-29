<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\Deparment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use stdClass;
use Excel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use PDF;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes = ["identification", "firstname", "lastname", "username", "phone_number", "email", "state", "department_id", "name", "role_id", "role_name"];
        $data['users'] = User::leftJoin('records', 'id', 'identification')
            ->join('departments', 'id_department', 'department_id')
            ->join('roles', 'id_role', 'role_id')
            ->select($attributes)
            ->selectRaw('count(id) as total')
            ->where('identification', '<>', 0)
            ->groupBy($attributes)
            ->get();
        $data['departments'] = Deparment::where('id_department', '<>', 1)->get();
        
        return view('user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles          = Role::where('id_role', '>', 1)->get();
        $departments    = Deparment::where('id_department', '>', 1)->get();

        $data               = new stdClass;
        $data->roles        = $roles;
        $data->departments  = $departments;
        return view('user.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            "identification" => ['required', 'numeric'],
            "firstname" => ['required', 'string'],
            "lastname" => ['required', 'string'],
            "username" => ['required', 'string'],
            "password" => ['required', 'string'],
            "department_id" => ['required', 'numeric'],
            "role_id" => ['required', 'numeric'],
        ]);
        $user = new User();
        $user->identification = $request->identification;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->state = 0;
        $user->department_id = $request->department_id;
        $user->role_id = $request->role_id;
        $user->save();
        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user           = User::find($id);
        $roles          = Role::where('id_role', '>', 1)->get();
        $departments    = Deparment::where('id_department', '>', 1)->get();

        $data               = new stdClass;
        $data->user         = $user;
        $data->roles        = $roles;
        $data->departments  = $departments;
        return view('user.edit', compact('data', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->department_id = $request->department_id;
        $user->role_id = $request->role_id;
        $user->save();
        return redirect('user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect('user');
    }

    /**
     * Update user state (EndPoint)
     * @param $id
     * @return Http\Response
     */
    public function updateState($id)
    {
        $user = User::find($id);
        $user->state = (int) $user->state == 0 ? 1 : 0;
        $user->update();
        $response = new stdClass;
        $response->success = 'ok';
        $response->user = $user;
        return $response;
    }

    public function history($id)
    {
        $attributes = ["identification", "firstname", "lastname", "department_id", "name"];
        $data['history'] = User::join('records', 'id', 'identification')
            ->join('departments', 'id_department', 'department_id')
            ->select($attributes)
            ->selectRaw('DATE_FORMAT(access_date, "%d/%b/%Y" ) as date')
            ->selectRaw('DATE_FORMAT(access_date, "%H:%i:%S" ) as time')
            ->where('identification', $id)->get();
        $data['identification'] = $id;
        //return $data;
        return view('user.history', $data);
    }

    public function filters(Request $request)
    {
        //return $request;
        $sql = "SELECT identification, firstname, lastname, username, role_name, phone_number, email, state, count(id) as total, department_id, role_id, name FROM users 
        LEFT JOIN records ON id = identification 
        JOIN departments ON id_department = department_id
        JOIN roles ON id_role = role_id
        WHERE identification <> 0";
        
        $regex = '/^[0-9]+$/';
        $filterId = preg_match($regex, $request->filter) ? true : false;

        $id = $filterId ? " and identification = '{$request->filter}'": null;
        $work =!$filterId && !is_null($request->filter)? " and firstname LIKE '%{$request->filter}%' or lastname LIKE '%{$request->filter}%' or username LIKE '%{$request->filter}%'": null;
        $dep = isset($request->department_id) ? " and id_department = {$request->department_id}": null;
        $sql.= $id. $work. $dep." GROUP BY identification, firstname, lastname, username, role_name, phone_number, email, state,  department_id,  role_id, name";

        $data['users'] = DB::select($sql);
        $data['departments'] = Deparment::where('id_department', '<>', 1)->get();
        return view('user.index', $data);
    }

    public function filterHistory(Request $request)
    {
        $val = (int) $request->clean;
        if($request->clean == 1 ) return $this->history($request->identification);
        $sql = "SELECT identification, firstname, lastname, name, department_id, CONCAT(DAY(access_date),'/', MONTH(access_date),'/', YEAR(access_date)) AS date, CONCAT(HOUR(access_date),':', MINUTE (access_date),':', SECOND(access_date)) AS time FROM users 
        INNER JOIN records ON id = identification 
        INNER JOIN departments ON id_department = department_id
        WHERE identification = {$request->identification}";   

        $initialDate    = $request->initial && $request->initial < now() ? " AND access_date BETWEEN '{$request->initial}'": " AND access_date BETWEEN '".now()."'" ;  
        $finalDate      = $request->final ? " AND '{$request->final}'": " AND '".now()."'" ;
        $sql .= $initialDate .$finalDate;
        $data['history'] = DB::select($sql);
        $data['identification'] = $request->identification;
        return view('user.history', $data);
    }

    public function import(Request $request)
    {
        //return $request->document;
        Excel::import(new UsersImport, $request->document);
        return redirect('user');
    }

    public function pdf($id)
    {
        $attributes = ["identification", "firstname", "lastname", "department_id", "name"];
        $data['history'] = User::join('records', 'id', 'identification')
            ->join('departments', 'id_department', 'department_id')
            ->select($attributes)
            ->selectRaw('DATE_FORMAT(access_date, "%d/%b/%Y" ) as date')
            ->selectRaw('DATE_FORMAT(access_date, "%H:%i:%S" ) as time')
            ->where('identification', $id)->get();
        $data['identification'] = $id;

        $pdf = PDF::loadView('user.pdf', $data);
        return $pdf->download("history_{$id}.pdf");
    }
}
