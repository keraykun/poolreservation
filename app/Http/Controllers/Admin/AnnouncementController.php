<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcements;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.announcement.index');
    }

  public function list()
    {
        $events = Announcements::all()->map(function ($announcement) {
            return [
                'publicId'=>$announcement->id,
                'title' => $announcement->title,
                'description'=>$announcement->description,
                'start' => Carbon::parse($announcement->due_at)->format('Y-m-d'),
            ];
        });

        return response()->json($events)->header('Content-Type', 'application/json');
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

        Announcements::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'due_at'=>$request->eventDate,
        ]);

        return response()->json('New announcement has been added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcements $announcements)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcements $announcements)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcements $announcement)
    {

        Announcements::where('id',$announcement->id)
        ->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'due_at'=>$request->startDate,
        ]);

        return response()->json('The announcement has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcements $announcement)
    {
        Announcements::destroy($announcement->id);
        return response()->json('The announcement has been deleted successfully.');
    }
}
