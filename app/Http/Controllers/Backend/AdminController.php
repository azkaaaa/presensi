<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\User;
use App\Employee;
use App\Position;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use DB;
use Validator;
use Hash;
use URL;
use File;

class AdminController extends Controller
{
    public function getProfile()
    {
    	$id = Auth::id();
        $user = User::find($id);
    	$employee = Employee::where('user_id',$id)->first();
        $position = Position::all();

    	$employee = DB::table('employees')
        ->where('employees.id', $employee->id)
        ->join('users', 'users.id', '=','employees.user_id')
        ->join('positions', 'positions.id', '=','employees.position_id')
        ->select('employees.id','employees.name','employees.nik','employees.id_card','employees.birthday','employees.religion','employees.address','employees.phone','employees.education','employees.account_number','employees.profile_picture', 'positions.id as position_id','positions.name as position_name','users.email','users.level','users.status')
        ->first();

        return view('backend.profile.index', ['employee'=>$employee, 'position'=>$position, 'user'=>$user]);
    }

    public function postChangeProfile(Request $request, $id)
    {
    	// $employee_id = Employee::where('user_id',$id)->first();

        $employee = Employee::find($id);
        $user_id = $employee->user->id;
        $user = User::find($user_id);

      	$this->validate($request,$employee->update_rules($id));
      	$employee->name = $request->name;
      	$employee->save();

      	$user->name = $request->name;
      	$user->save();

        session()->flash('message', 'Profile anda berhasil diperbarui.');

  		return redirect()->route('user.profile.index');
    }

    public function postChangePassword(Request $request)
	{
		$id = Auth::id();
        $user = User::find($id);
		// $user = User::where('id',$customer->user_id)->first();

		$passwordrules = [
            	'oldpassword' => 'required',
	    		'newpassword' => 'required|min:8',
	    		'confirmpassword' => 'required||same:newpassword'
        ];

	    $validator = Validator::make($request->all(), $passwordrules);

	    if($validator->fails())
        {
        	session()->flash('password_not_same',true);
            return Redirect::to(URL::previous() . "#password")
            ->withErrors($validator)
            ->withInput();
        }
        else{

        	$userdata = $request->all();
		    if(!Hash::check($userdata['oldpassword'], $user->password))
		    {
		     session()->flash('password_incorrect',true); 
	         return Redirect::to(URL::previous() . "#password");
		    
		    }else{
		        $user->password = Hash::make($request->newpassword);
		    	$user->save();
		    	session()->flash('password_correct',true); 
		    }
        }

        session()->flash('message', 'Password anda berhasil diperbarui.');

	    return Redirect::to(URL::previous() . "#password");
	}

	public function postChangePicture(Request $request)
    {
    	$id = Auth::id();
    	$employee_id = Employee::where('user_id',$id)->first();

        $employee = Employee::find($employee_id->id);

        if($request->hasfile('profile_picture')){
        	$files = public_path().'/admin/uploads/profile_picture/'.$employee->profile_picture;
            File::delete($files);
            
            $filename = md5('profile_picture'.$employee_id).'.'.$request->file('profile_picture')->getClientOriginalExtension();
            $upload_result = $request->file('profile_picture')->move(public_path().'/admin/uploads/profile_picture/',$filename);
			if($upload_result){
				$employee->profile_picture = $filename;
			}
        }

	    else{
        	session()->flash('profile_picture_failed',true);

  			return redirect()->route('user.profile.index');
	    }

      	// $this->validate($request,$employee->update_rules($id));
      	// $employee->profile_picture = $request->profile_picture;
      	$employee->save();

        session()->flash('message', 'Foto profil anda berhasil diperbarui.');

  		return redirect()->route('user.profile.index');
    }

    public function getChangePicture(Request $request)
    {
    	return view('backend.profile.picture');
    }
}
