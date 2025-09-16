<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Http\Resources\FarmResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class FarmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->authorize('viewAny', Farm::class);

        $farms = Farm::orderBy('created_at','desc')->paginate(20);
        return FarmResource::collection($farms)->preserveQuery();
    }

    public function farms()
    {
        //
        $this->authorize('viewAny', Farm::class);

        $farms = Farm::orderBy('created_at','asc')->get();
        return response(['farms' => FarmResource::collection($farms)]);
    }

    public function search(Request $request)
    {
        //
        $this->authorize('viewAny', Farm::class);

        $input=$request->all();
        $farm = Farm::where('name','LIKE','%'.$input['searchTerm'].'%')
                        ->orderBy('created_at','asc')
                        ->paginate(20);
        return FarmResource::collection($farm)->preserveQuery();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->authorize('create', Farm::class);

        $input=$request->all();
        $validator = Validator::make($input, [
            'address'=>'required',
         ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
          }
        $farm=Farm::create($input);
        return new FarmResource($farm);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function show(Farm $farm)
    {
        //
        $this->authorize('view', $farm);

        return new FarmResource($farm);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Farm $farm)
    {
        //
        $this->authorize('update', $farm);

        $input=$request->all();
        $farm->update($input);
        return new FarmResource($farm);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function destroy(Farm $farm)
    {
        //
        $this->authorize('delete', $farm);

        $farm->delete();
        return response(['message' => 'farm was deleted successfully']);
    }
}