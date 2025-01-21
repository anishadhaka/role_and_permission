<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class StateController extends Controller
{
public function index(Request $request)
{
    // if ($request->ajax()) {
    //     $state = State::all();
    //     return DataTables::of($state)->make(true);
    // }
    if ($request->ajax()) {
        $state = State::all();
        return DataTables::of($state)
            ->addColumn('action', function ($state) {
                $editUrl = route('State.edit', $state->id);
                $deleteUrl = route('State.destroy', $state->id);
                return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                    <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this State?\')">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                ';
            })
            ->rawColumns(['action']) 
            ->make(true);
    }
    return view('backend.State.index');
}
public function create()
{
    return view('backend.State.create');
}
public function store(Request $request)
{
    State::create($request->all());
    return redirect()->route('State.index')->with('success', 'Created successfully.');
}


public function edit($id)
{
     $state = State::findOrFail($id);
     return view('backend.State.edit', compact('state'));
}

public function update(Request $request,$id)
{
     $domain = State::findOrFail($id);
     $domain->update($request->all());

   return redirect()->route('State.index')
    ->with('success', 'State updated successfully.');
}


/**
 * Remove the specified resource from storage.
 */
public function destroy($id)
{
State::where('id',$id)->firstOrFail()->delete();

return redirect()->route('State.index')
                ->with('success','State deleted successfully');
}
}
