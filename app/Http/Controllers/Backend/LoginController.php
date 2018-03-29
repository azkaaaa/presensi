<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

use App\User;
use App\Employee;
use App\Http\Controllers\Controller;

use Hash;
use Session;

class LoginController extends Controller
{
    public function getLogin()
    {
        return view('backend.login.login');
    }

    public function postLogin(Request $request)
    { 
      $remember_me = $request->has('remember_me') ? true : false; 
      
      $user = User::where('email',$request->email)->first();
      if($user){
        if(Hash::check($request->password,$user->password)){
          $user = User::where('id',$user->id)->where('status','1')->first();

          // dd($user-name);
          
          if($user){
            session()->put('user_id',$user->id);
            session()->put('email',$user->email);
            session()->put('name',$user->name);
            session()->put('level',$user->level);

            if($user->level == 'admin'){
            	return redirect()->route('admin.dashboard.index');
            }
            elseif($user->level == 'employee'){
            	return redirect()->route('employee.dashboard.index');
            }
            elseif($user->level == 'manager'){
            	return redirect()->route('manager.dashboard.index');
            }

          }
          
          session()->flash('active_user_email_not_found',$request->email);
        }
        else{
          session()->flash('password_incorrect',true);  
        }
      }
      else{
        session()->flash('user_email_not_found',$request->email);
      }

      return redirect()->route('user.login.index')->withInput($request->except('password'));
    }

    public function destroy()
    {
        Auth()->logout();
        Session::flush();

        // return redirect()->route('backend.login.login');
        return redirect()->route('user.login.index');
    }
}
