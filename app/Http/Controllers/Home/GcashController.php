<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Gcash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class GcashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        // Validate the incoming request
        $request->validate([
            'file' => 'required|mimes:jpeg,png,pdf,docx|max:30000', // 30MB limit
        ]);

        // Retrieve the file from the request
        $file = $request->file('file');

        // Generate a unique filename
        $filename = time() . '_' . $file->getClientOriginalName();

        // Move the file to the storage location
        $file->move(public_path('images/gcash'), $filename); // You can change the storage path


        DB::transaction(function () use($filename,$request){
            Gcash::create([
                'barcode'=>$request->barcode,
                'image'=>$filename
            ]);
        });

        // Perform additional operations if needed, such as saving the filename to the database

        // Return a response indicating success
        return response()->json(['message' => 'File uploaded successfully','userID'=>Auth::id()]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $gcash = Gcash::where('barcode',$id)->first();
        $image = $gcash->image;
        $path = public_path('/images/gcash/'.$image);
        if(file_exists($path)){
            unlink($path);
        }

        $file = $request->file('image');
        $fileName = $file->getClientOriginalName();
        // Move the file to the storage location
        $file->move(public_path('images/gcash'), $fileName); // You can change the storage path
        $gcash->update(['image' => $fileName]);
       return redirect()->back()->with('success','Proof of payment has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
