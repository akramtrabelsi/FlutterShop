<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::simplePaginate(env('PAGINATION',16));
        return view('admin.units.units')->with(['units'=>$units]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO check if unit exist
        $request->validate([
            'unit_name' => 'required',
            'unit_code' => 'required'
        ]);
        $unitName = $request->input('unit_name');
        $unitCode = $request->input('unit_code');

        if (! $this->unitNameExists($unitName)){
            return redirect()->back();
        }
        if (!$this->unitCodeExists($unitCode)){
            return redirect()->back();
        }

        $unit = new Unit();

        $unit->unit_name = $request->input('unit_name');
        $unit->unit_code = $request->input('unit_code');
        $unit->save();
        Session::flash('message', 'Unit '.$unit->unit_name. ' has been added' );
        return redirect()->back();


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        //
    }
    public function delete(Request $request){
        if(is_null($request->input('unit_id'))||empty($request->input('unit_id'))){
            $request->flash('message', 'unit ID is required');
            return redirect()->back();
        }
        $id = $request->input('unit_id');
        Unit::destroy($id);
        Session::flash('message','Unit has been deletes');
        return redirect()->back();
    }


    public function put(Request $request)
    {
        $request->validate([
            'unit_code' => 'required',
            'unit_id' => 'required',
            'unit_name' => 'required'
        ]);
        $unitName = $request->input('unit_name');
        $unitCode = $request->input('unit_code');

        if (! $this->unitNameExists($unitName)){
            return redirect()->back();
        }
        if (!$this->unitCodeExists($unitCode)){
            return redirect()->back();
        }
        $unitID = intval($request->input('unit_id'));

        $unit = Unit::find($unitID);

        $unit->unit_name = $request->input('unit_name');
        $unit->unit_code = $request->input('unit_code');
        $unit->save();
        Session::flash('message', 'Unit ' . $unit->unit_name . ' has been updated');
        return redirect()->back();
    }

    private function unitNameExists($unitName)
    {
        $unit = Unit::where(
            'unit_name', '=', $unitName
        )->first();
        if (!is_null($unit)) {
            Session::flash('message', 'Unit Name(' . $unitName . ') already exists');
            return false;


        }
        return true;
    }

    private function unitCodeExists($unitCode)
    {
        $unit = Unit::where(
            'unit_code', '=', $unitCode
        )->first();
        if (!is_null($unit)) {
            Session::flash('message', 'Unit Name(' . $unitCode . ') already exists');
            return false;
        }
        return true;
    }
}
