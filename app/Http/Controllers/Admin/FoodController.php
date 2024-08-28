<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Foods;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    //    $foods = Foods::all();

    //    $tableRows = '';
    //    foreach ($foods as $food) {
    //        $tableRows .= '<tr>';
    //        $tableRows .= '<td>' . $food->name . '</td>';
    //        $tableRows .= '<td>' . $food->price . '</td>';
    //        $tableRows .= '<td class="flex gap-3">';
    //        $tableRows .= '<a class="btn-sm btn bg-sky-700 hover:bg-sky-800 text-white rounded-md shadow-md"">EDIT</a>';
    //        $tableRows .= '<a class="btn-sm btn bg-red-700 hover:bg-red-800 text-white rounded-md shadow-md" href="#">DELETE</a>';
    //        $tableRows .= '</td>';
    //        $tableRows .= '</tr>';
    //    }
    //   return view('admin.foods.index',['foods'=>$foods]);

        return view('admin.foods.index');
    }

    public function  list(){

        $foods =  Foods::orderBy('id', 'desc')->get();

        $tableRows = '';
        foreach ($foods as $food) {
            $formattedPrice = number_format($food->price);

            $tableRows .= '<tr>';
            $tableRows .= '<td>' . $food->name . '</td>';
            $tableRows .= '<td> ₱ ' . $formattedPrice . '</td>';
            $tableRows .= '<td class="flex gap-3">';
            $tableRows .= '<button type="button"  class="btn-sm btn bg-sky-700 hover:bg-sky-800 text-white rounded-md shadow-md" onclick="editFood('.$food->id.')">EDIT</button>';
            $tableRows .= '<button type="button"  class="btn-sm btn bg-red-700 hover:bg-red-800 text-white rounded-md shadow-md" onclick="deleteFood('.$food->id.')">DELETE</button>';
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

        Foods::create([
            'name'=>$request->foodName,
            'price'=>$request->foodPrice,
        ]);

        return response()->json(['message'=>'successfully added']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Foods $foods)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Foods $food)
    {
       return $food;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Foods $food)
    {

        Foods::where('id',$food->id)
        ->update([
            'name'=>$request->editFoodName,
            'price'=>$request->editFoodPrice,
        ]);
        return response()->json(['message'=>'successfully updated']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Foods $food)
    {
        Foods::destroy($food->id);
        return response()->json(['message'=>'successfully deleted']);
    }
}
