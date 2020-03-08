<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FarmAdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth:managers');
        $this->middleware('verified');
    }

    public function dashboard()
    {
        $is_setup = \App\Farm::where('is_setup',false)->find(auth()->user()->farm_id);
        if( $is_setup)
            return view('admin.sup_admin.setup');
        return view('admin.sup_admin.index');
    }

    public function profile()
    {

        return view('admin.sup_admin.profile');
    }

    public function index($type)
    {
        switch ($type) {
            case 'chicken':
                return view('admin.sup_admin.chicken.index');
                break;

            case 'turkey':
                return view();
                break;
            case 'guinea_fowl':
                return view();
                break;
        }
    }

    public function birdType($type)
    {
        switch ($type) {
            case 'chicken':
                return redirect()->route('admin.home',$type);
                break;

            case 'turkey':
                return redirect()->route('admin.home',$type);
                break;
            case 'guinea_fowl':
                return redirect()->route('admin.home',$type);
                break;
        }
    }

    /**
     * Get bird population
     */
    public function population($type)
    {
        $pen = \App\PenHouse::select('pen_id')->where('farm_id',auth()->user()->farm_id)->get();
        switch ($type) {
            case 'chicken':
                return view('admin.sup_admin.chicken.population',compact('pen'));
                break;

            case 'turkey':
                return view();
                break;
            case 'guinea_fowl':
                return view();
                break;
        }
    }


    /**
     * add bird to database
     */
    public function addBird(Request $request,$type)
    {
       //dd($request->all());
        $request->validate([
        "species" => ['required'],
        "type" => ['required'],
        "pen" => ['required','string'],
        "number" => ['required','numeric','min:0'],
        "price" => ['required','numeric','min:0'],
        "date" => ['required','date']
        ]);

        $farm = \App\Farm::find(auth()->user()->farm_id);

        \App\Birds::create([
            "batch_id" => generate_batch_id($farm->farm_name),
            "farm_id" => auth()->user()->farm_id,
            "bird_category" => $type,
            'pen_id' => $request->pen,
            'number' => $request->number,
            "species" => $request->species,
            "type" => $request->type,
            "unit_price" => $request->price,
            "date" => date($request->date),
        ]);
        return redirect()->back()->with('success','Bird added successfully!');
    }

    public function mortality($type)
    {
        $pen = \App\PenHouse::select('pen_id')->where('farm_id',auth()->user()->farm_id)->get();
        $batch_id = \App\Birds::select('batch_id')->where('farm_id',auth()->user()->farm_id)->get();
        switch ($type) {
            case 'chicken':
                return view('admin.sup_admin.chicken.mortality',compact('pen','batch_id'));
                break;

            case 'turkey':
                return view();
                break;
            case 'guinea_fowl':
                return view();
                break;
        }
    }

    public function addMortality($type,Request $request)
    {
        // dd($request->all());
        $request->validate([
            "batch_id" => ['required','string'],
            "pen" => ['required','string'],
            "number" => ['required','numeric','min:0'],
            "date" => ['required','date'],
            "unit_price" => ['required','numeric','min:0'],
            "cause" => ['required','string'],
            "observation" => ['sometimes','string','nullable'],
            ]);

            \App\BirdMortality::create([
            "batch_id" => $request->batch_id,
            "farm_id" => auth()->user()->farm_id,
            "pen_id" => $request->pen,
            "number" => $request->number,
            "dod" =>  new \DateTime($request->date),
            "unit_price" => $request->unit_price,
            "cause" => $request->cause,
            "observation" => $request->observation,
            ]);
            return redirect()->back()->with('success','Mortality added successfully');
    }

    public function addPen(Request $request)
    {
        //dd($request->id);
        $request->validate([
            "id" => ['required','string','unique:pen_houses,pen_id'],
            "location" => ['required','string'],
            "size" => ['required','numeric','min:0'],
            "capacity" => ['required','numeric','min:0'],
        ]);
        // dd(\generate_pen_id("the farm"));
        \App\PenHouse::create([
            'pen_id'=> $request->id,
            "farm_id" => \auth()->user()->farm_id,
            "location" => $request->location,
            "size" => $request->size,
            "capacity" => $request->capacity
        ]);

        return back()->with('success','Pen House added successfully');

    }

    public function setupBird()
    {
        // $is_setup = \App\Farm::where('is_setup',false)->find(auth()->user()->farm_id);
        // if( $is_setup)
        $pen = \App\PenHouse::select('pen_id')->where('farm_id',auth()->user()->farm_id)->get();
            return view('admin.sup_admin.setup_bird',compact('pen'));
    }

    public function setupFinish()
    {
        $has_bird = \App\Birds::where('farm_id',auth()->user()->id)->get();

        if(isset($has_bird) && count($has_bird) > 0){
            $farm = \App\Farm::where('id',auth()->user()->farm_id)->find(auth()->user()->farm_id);
            $farm->is_setup = true;
            $farm->save();
            return redirect('/dashboard');
        }
        return back()->with('error','Please Add Birds to proceed');
    }

    public function eggProduction($type)
    {
        $pen = \App\PenHouse::select('pen_id')->where('farm_id',auth()->user()->farm_id)->get();
        $batch_id = \App\Birds::select('batch_id')->where('farm_id',auth()->user()->farm_id)->get();
        switch ($type) {
            case 'chicken':
                return view('admin.sup_admin.chicken.egg_production',compact('pen','batch_id'));
                break;

            case 'turkey':
                return view();
                break;
            case 'guinea_fowl':
                return view();
                break;
        }
    }

    public function addEggProduction($type,Request $request)
    {
        //dd($request->all());
        $request->validate([
            "batch_id" => ['required','string'],
            "pen" => ['required','string'],
            "number" => ['required','numeric','min:0'],
            "date" => ['required','date'],
            "bad_eggs" => ['required','numeric','min:0'],
            ]);

            \App\EggProduction::create([
            "layer_batch_id" => $request->batch_id,
            "farm_id" => auth()->user()->farm_id,
            "pen_id" => $request->pen,
            "quantity" => $request->number,
            "date_collected" =>  new \DateTime($request->date),
            "bad_eggs" => $request->bad_eggs,
            "bird_category" => $type,

            ]);
            return redirect()->back()->with('success','Eggs record added successfully');
    }
}
