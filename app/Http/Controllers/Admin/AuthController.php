<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{


public function loginPage()
{

return view('admin.login');

}




public function login(Request $request)
{


$credentials=$request->validate([

'email'=>'required',
'password'=>'required'

]);



if(Auth::attempt($credentials))
{


if(Auth::user()->is_admin)
{


return redirect('/admin/dashboard');


}


Auth::logout();


}



return back()->with(
'error',
'Invalid Admin Account'
);



}



public function logout()
{

Auth::logout();

return redirect('/admin/login');

}



}