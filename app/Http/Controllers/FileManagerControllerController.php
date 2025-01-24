<?php

namespace App\Http\Controllers;

use App\Models\FileManagerController;
use App\Http\Requests\StoreFileManagerControllerRequest;
use App\Http\Requests\UpdateFileManagerControllerRequest;

class FileManagerControllerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.filemanager.filemanager');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFileManagerControllerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FileManagerController $fileManagerController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FileManagerController $fileManagerController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFileManagerControllerRequest $request, FileManagerController $fileManagerController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FileManagerController $fileManagerController)
    {
        //
    }
}
