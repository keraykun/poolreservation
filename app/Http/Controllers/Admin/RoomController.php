<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.room.index');
    }

    public function  list(){

        $foods =  Room::orderBy('id', 'desc')->get();

        $tableRows = '';
        foreach ($foods as $food) {
            $formattedPrice = number_format($food->price);

            $tableRows .= '<tr>';
            $tableRows .= '<td>' . $food->name . '</td>';
            $tableRows .= '<td> ₱ ' . $formattedPrice . '</td>';
            $tableRows .= '<td class="flex gap-3">';
            $tableRows .= '<button type="button"  class="btn-sm btn bg-sky-700 hover:bg-sky-800 text-white rounded-md shadow-md" onclick="editRoom('.$food->id.')">EDIT</button>';
            $tableRows .= '<button type="button"  class="btn-sm btn bg-red-700 hover:bg-red-800 text-white rounded-md shadow-md" onclick="deleteRoom('.$food->id.')">DELETE</button>';
            $tableRows .= '</td>';
            $tableRows .= '</tr>';
        }

        echo $tableRows;
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
       // return $request;

        Room::create([
            'name'=>$request->roomName,
            'price'=>$request->roomPrice,
        ]);

        return response()->json(['message'=>'successfully added']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $rooms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return $room;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {

       // return $request;
        Room::where('id',$room->id)
        ->update([
            'name'=>$request->editRoomName,
            'price'=>$request->editRoomPrice,
        ]);
        return response()->json(['message'=>'successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        Room::destroy($room->id);
        return response()->json(['message'=>'successfully deleted']);
    }
}
