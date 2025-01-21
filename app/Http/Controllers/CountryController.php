<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
public function index(Request $request)
{
    if ($request->ajax()) {
        $country = Country::select(['id','name' ,'country_code','time_zone']);
        return DataTables::of($country)
        ->addColumn('action', function ($country) {
            $editUrl = route('Country.edit', $country->id);
            $deleteUrl = route('Country.destroy', $country->id);
            return '
                <a href="' . $editUrl . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this Country?\')">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                </form>
            ';
        })
        ->rawColumns(['action']) 
        ->make(true);
    }
    
    return view('backend.Country.index');
}
public function create()
{
    return view('backend.Country.create');
}
public function store(Request $request)
{
    // $request->validate([
    //     'country_name' => 'required|unique:country,country_name|max:255',
    // ]);
    Country::create($request->all());
    return redirect()->route('Country.index')->with('success', 'Country created successfully.');
}
public function edit($id)
{
    $Country = Country::findOrFail($id);
    return view('backend.Country.edit', compact('Country'));
}

public function update(Request $request,$id)
{
    $Country = Country::findOrFail($id);
    $Country->update($request->all());

    return redirect()->route('Country.index')
        ->with('success', 'Country updated successfully.');
}
    
public function destroy($id)
{
    Country::where('id',$id)->firstOrFail()->delete();
    
    return redirect()->route('Country.index')
                    ->with('success','Country deleted successfully');
}
}
