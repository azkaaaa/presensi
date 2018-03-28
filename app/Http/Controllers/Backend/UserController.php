<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;

use Auth;

class UserController extends Controller
{

	public function index()
    {
        return view('backend.user.index');
    }

  public function getIndex()
    {
        return view('backend.user.index');
    }


	public function dataUsers()
  	{
    	 $users = User::select(['id', 'name', 'email', 'level', 'status', 'created_at', 'updated_at']);

	      return Datatables::of($users)
	      ->addColumn('action', function ($users) {
                return '<a href="'.url('admin/user/'. $users->id .'/edit').'" class="btn btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>
                
                <form method="POST" action="'.url('admin/user/'. $users->id).'" style="display: inline">  
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' .csrf_token(). '">
                        <button class="btn-sm btn-danger" type="submit" style="border: none"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</button>
                 </form>';
            }
            )
            ->make(true);
    
  
  	}


    public function create()
    {
        return view('backend.user.create');
    }

    public function store(Request $request)
    {   
      $user = Auth::id();

      $position =  new Position();
      $this->validate($request,$position->rules);
      $position->fill($request->all());
      $position->user_id = $user;
      $position->save();

     return redirect('/admin/position');
    }


    public function edit($id)
    {
        $position = Position::find($id);

        return view('backend.position.edit')->with('position', $position);
    }
    
    public function update(Request $request, $id)
    {
        $user = $request->session()->get('admin_id');

        $position = Position::find($id);
        $this->validate($request,$position->rules);
        $position->fill($request->all());
        $position->user_id = $user;
        $position->save();

        session()->flash('message', 'Your Position has been updated.');

        return redirect('/admin/position');
    }

    public function destroy($id)

	{
		Position::find($id)->delete();

        session()->flash('message', 'Your Position price has been deleted.');

		return redirect('/admin/position');
	}

}
