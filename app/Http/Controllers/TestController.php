<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        $data = Test::all();
        return view('backend.tests.index', compact('data'));
    }

    public function create()    
    {
        
$name = DB::table('blogs')->pluck('name', 'id');
 
  return view('backend.tests.create', compact('name'));

    }

    public function store(Request $request)
    {
        Test::create($request->all());
        return redirect()->route('tests.index')->with('success', 'Test created successfully.');
    }

  public function edit($id)
{
   $item = Test::findOrFail($id);
    
$name = DB::table('blogs')->pluck('name', 'id');;

   return view('backend.tests.edit', compact('item', 'name'));

}


    public function update(Request $request, $id)
    {
        $item = Test::findOrFail($id);
        $item->update($request->all());
        return redirect()->route('tests.index')->with('success', 'Test updated successfully.');
    }

    public function destroy($id)
    {
        Test::where('id', $id)->firstOrFail()->delete();
        return redirect()->route('tests.index')->with('success', 'Deleted successfully.');
    }
}