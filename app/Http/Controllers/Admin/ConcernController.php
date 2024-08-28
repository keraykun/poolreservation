<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concerns;
use Illuminate\Http\Request;

class ConcernController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $concerns = Concerns::all();
       return view('admin.concern.index',['concerns'=>$concerns]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Concerns $concerns)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Concerns $concerns)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Concerns $concerns)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Concerns $concerns)
    {
        //
    }
}
