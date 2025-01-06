<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $department = Department::select(['id', 'department_name']);
            return DataTables::of($department)
            ->addColumn('action', function ($department) {
                return '
                    <a class="btn btn-primary btn-sm" href="'.route('department.edit', $department->id).'">Edit</a>
                    <form method="POST" action="'.route('department.destroy', $department->id).'" style="display:inline">
                        '.csrf_field().method_field('DELETE').'
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                ';
            })
                ->rawColumns(['action'])
                ->make(true);

        }
        return view('department.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('department.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string|max:255',
           
        ]);
    
        Department::create($request->all());
    
        return redirect()->route('department.index')
            ->with('success', 'department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $department= Department::findorfail($id);
        return view('department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'department_name' => 'required|string|max:255',
            
        ]);
        $department = Department::findOrFail($id);
        $department->update($request->all());
    
        return redirect()->route('department.index')
            ->with('success', 'department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Department::where('id',$id)->firstorfail()->delete();
        return redirect()->route('department.index')
                                ->with('deleted successfully');
    }
}
