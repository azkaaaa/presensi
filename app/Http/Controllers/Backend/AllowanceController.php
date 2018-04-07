<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\User;
use App\Allowance;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;

use Auth;

class AllowanceController extends Controller
{

	public function index()
    {
        return view('backend.allowance.index');
    }

  public function getIndex()
    {
        return view('backend.allowance.index');
    }


	public function dataAllowances()
  	{
    	 $allowances = Allowance::select(['id', 'name', 'price', 'created_at', 'updated_at']);

	      return Datatables::of($allowances)
	      ->addColumn('action', function ($allowances) {
                return '<a href="'.url('admin/allowance/'. $allowances->id .'/edit').'" class="btn btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>
                
                <form method="POST" action="'.url('admin/allowance/'. $allowances->id).'" style="display: inline">  
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
        return view('backend.allowance.create');
    }

    public function store(Request $request)
    {   
      $allowance =  new Allowance();
      $this->validate($request,$allowance->rules);
      $allowance->fill($request->all());
      $allowance->save();

      session()->flash('message', 'Anda berhasil menambahkan data tunjangan.');

     return redirect('/admin/allowance');
    }


    public function edit($id)
    {
        $allowance = Allowance::find($id);

        return view('backend.allowance.edit')->with('allowance', $allowance);
    }
    
    public function update(Request $request, $id)
    {
        // $user = Auth::id();

        $allowance = Allowance::find($id);
        $this->validate($request,$allowance->rules);
        $allowance->fill($request->all());
        $allowance->save();

        session()->flash('message', 'Data tunjangan berhasil diperbarui.');

        return redirect('/admin/allowance');
    }

    public function destroy($id)
  	{
  		Allowance::find($id)->delete();

          session()->flash('message', 'Data tunjangan berhasil dihapus.');

  		return redirect('/admin/allowance');
  	}

}
