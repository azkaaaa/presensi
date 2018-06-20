<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\User;
use App\Position;
use App\Employee;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;

use Auth;
use Carbon\Carbon;


class PositionController extends Controller
{

	public function index()
    {
        return view('backend.position.index');
    }

  public function getIndex()
    {
        return view('backend.position.index');
    }


	public function dataPositions()
  	{
    	 $positions = Position::select(['id', 'name', 'salary', 'transport', 'created_at', 'updated_at']);

	      return Datatables::of($positions)
	      ->addColumn('action', function ($positions) {
                return '<a href="'.url('admin/position/'. $positions->id .'/edit').'" class="btn btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>
                
                <form method="POST" action="'.url('admin/position/'. $positions->id).'" style="display: inline">  
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' .csrf_token(). '">
                        <button class="btn-sm btn-danger" type="submit" style="border: none" onclick="return myFunction();"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</button>
                 </form>';
            }
            )
            ->make(true);
    
  
  	}


    public function create()
    {
        return view('backend.position.create');
    }

    public function store(Request $request)
    {   
      $user = Auth::id();

      $position =  new Position();
      $this->validate($request,$position->rules);
      $position->fill($request->all());
      $position->save();

      session()->flash('message', 'Anda berhasil menambahkan data jabatan.');

     return redirect('/admin/position');
    }


    public function edit($id)
    {
        $position = Position::find($id);

        return view('backend.position.edit')->with('position', $position);
    }
    
    public function update(Request $request, $id)
    {
        $user = Auth::id();

        $position = Position::find($id);
        $this->validate($request,$position->rules);
        $position->fill($request->all());
        $position->save();

        session()->flash('message', 'Data jabatan berhasil diperbarui.');

        return redirect('/admin/position');
    }

    public function destroy($id)
  	{
  		$delete = Position::findOrFail($id);
      $employees = Employee::all();
      $match = '';

      foreach ($employees as $employee)
      {
          if ($employee->position_id == $id)
          {
              $match = 'found';
          }
      }

      if ($match == 'found')
      {
          session()->flash('message', 'Hapus data karyawan dengan jabatan bersangkutan dahulu.');
          return redirect('/admin/position');
      } 
      else {
          $delete->delete();
          session()->flash('message', 'Data jabatan berhasil dihapus');
  		    return redirect('/admin/position');
  	   }
    }
}
