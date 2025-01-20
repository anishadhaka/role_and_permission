<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class CityController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $cities = City::all();
            return DataTables::of($cities)
                ->addColumn('action', function ($city) {
                    $editUrl = route('City.edit', $city->id);
                    $deleteUrl = route('City.destroy', $city->id);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                        <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this city?\')">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                    ';
                })
                ->rawColumns(['action']) // Ensure the action column renders HTML
                ->make(true);
        }
        return view('backend.City.index');
    }
    

    public function create()
    {
        return view('backend.City.create');
    }

    public function store(Request $request)
    {
        City::create($request->all());
        return redirect()->route('City.index')->with('success', 'Created successfully.');
    }
    public function edit($id)
{
    $city = City::findOrFail($id);
    return view('backend.City.edit', compact('city'));
}

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request,$id)
{
  

    $domain = City::findOrFail($id);
    $domain->update($request->all());

    return redirect()->route('City.index')
        ->with('success', 'Domain updated successfully.');
}
    

    /**
     * Remove the specified resource from storage.
     */
public function destroy($id)
{
    City::where('id',$id)->firstOrFail()->delete();
    
    return redirect()->route('City.index')
                    ->with('success','City deleted successfully');
}
}
