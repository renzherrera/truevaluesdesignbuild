<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePositionRequest;
use App\Models\Position;
use Illuminate\Http\Request;
use App\DataTables\PositionDataTable;
use DataTables;
use Exception;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if (request()->ajax()) {
            if(!empty($request->from_date)){

                $data = DB::table('positions')
                ->whereBetween('created_at',array($request->from_date, $request->to_date))
                ->get();
            }
            else {
                $data = DB::table('positions')
                ->get();
            }
            return datatables()->of($data)->make(true);
           
        }
        return view('admin.positions.list-position');


        // return $dataTable->render('admin.positions.list-position');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.positions.create-position');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePositionRequest $request)
    {
        Position::create($request->validated());

        return redirect()->route('admin.positions.create');  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('livewire.admin.position.edit-position');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position) {
        try{
            $position->delete();
            return redirect()->route('admin.list-position')->with('success','Successfully Deleted');  

            }catch(Exception $ex){
                return redirect()->route('admin.list-position')->with('foreignError','You are not allowed');  

            }
    }
}
