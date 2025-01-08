<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Department;
use App\Http\Requests\StoreDesignationRequest;
use App\Http\Requests\UpdateDesignationRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $designation = Designation::select(['id', 'designation_name','department_id','level'])->get();

            return DataTables::of($designation)
            ->editColumn('department_id', function ($row) {
                return $row->departments ? $row->departments->department_name : 'N/A';
            })
    
                ->addColumn('action', function ($designation) {
                    return '
                       
                        <a class="btn btn-primary btn-sm" href="'.route('designation.edit', $designation->id).'">Edit</a>
                        <form method="POST" action="'.route('designation.destroy', $designation->id).'" style="display:inline">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('designation.index');
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         
       $department=Department::pluck('department_name','id');
    //    dd($department);
        return view('designation.create',compact('department'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'designation_name' => 'required|string|max:255',
           
        ]);
    
        Designation::create($request->all());
        return redirect()->route('designation.index')
            ->with('success', 'designation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
       $department=Department::pluck('department_name','id');
         $designation= Designation::findorfail($id);
        return view('designation.edit', compact('designation','department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([
          'designation_name'=> 'required'
        ]);
        $designation= Designation::findorFail($id);
        $designation->update($request->all());
        return redirect()->route('designation.index')
        ->with('updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Designation::where('id',$id)->firstorfail()->delete();
        return redirect()->route('designation.index')
        ->with('deleted successfully');
    }
}
