<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Menu;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use File;

use Yajra\Datatables\Datatables;

class MenuController extends Controller
{
	public function index()
	{
		return view('backend.menu.index');
	}

	public function dataMenus()
	{
		$menus = Menu::select(['id', 'name', 'price', 'type', 'status', 'desc', 'picture', 'created_at', 'updated_at']);

		return Datatables::of($menus)
		->addColumn('action', function ($menus) {
			return '<a href="'.url('admin/menu/'. $menus->id .'/edit').'" class="btn-sm btn-primary"> Edit</a>

			<form method="POST" action="'.url('admin/menu/'. $menus->id).'" style="display: inline">  
				<input type="hidden" name="_method" value="DELETE">
				<input type="hidden" name="_token" value="' .csrf_token(). '">
				<button class="btn-sm" type="submit" style="border: none" onclick="return myFunction();"> Hapus</button>
			</form>';
		}
	)
		->make(true);
	}

	public function create()
	{
		return view('backend.menu.create');
	}

	public function store(Request $request)
	{   
		// $menu =  new Menu();
		// $this->validate($request,$menu->rules);
		// $menu->fill($request->all());
		// $menu->save();

		// session()->flash('message', 'Anda berhasil menambahkan data makanan.');

		// return redirect('/admin/menu');
		 
	      
	      // if ($request->hasFile('picture')) {
	      // $file = $request->file('picture');
	      // $filename = $file->getClientOriginalName();
	      // $picture = md5('menus_').$filename;
	      // $destinationPath = public_path() . '\admin\uploads\menus';
	      // $file->move($destinationPath, $picture);

	      $menu =  new Menu();
	      $this->validate($request,$menu->rules);
	      $menu->fill($request->all());
	      // $menu->picture = $picture;
	      $menu->save();

	      session()->flash('message', 'Menu anda berhasil ditambahkan');
	     	return redirect('/admin/menu');
	    // }
	    //     else{
	    //         session()->flash('message', 'Please input gambar terlebih dahulu');
	    //             return redirect()->back();
	    //     }
    }
	

	public function update(Request $request, $id)
	{
		
		$menu = Menu::find($id);
		$this->validate($request,$menu->rules);
		$menu->fill($request->all());
		$menu->save();

		session()->flash('message', 'Data makanan berhasil diperbarui.');

		return redirect('/admin/menu');
	}

	public function edit($id)
	{
		$menu = Menu::find($id);
		return view('backend.menu.edit')->with('menu', $menu);
	}

	public function destroy($id)
	{
		Menu::find($id)->delete();
		session()->flash('message', 'Data makanan berhasil dihapus.');
		return redirect('/admin/menu');
	}
}
