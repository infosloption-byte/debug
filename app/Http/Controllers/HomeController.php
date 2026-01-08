<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use System\Employee\Models\Employee;
use System\Department\Models\Department;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $aa = \Auth::user();
        $user = User::with('employee')->find($aa->id);

        $department = Department::find($user->employee->department_id);

        return view('home.home',compact('user','department'));
    }
}
