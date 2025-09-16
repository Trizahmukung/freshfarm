<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Http\Resources\DeliveryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->authorize('viewAny', Delivery::class);

        $Deliveries = Delivery::orderBy('created_at','desc')->paginate(20);
        return DeliveryResource::collection($Deliveries)->preserveQuery();
    }

    public function deliveries()
    {
        //
        $this->authorize('viewAny', Delivery::class);

        $Deliveries = Delivery::orderBy('created_at','asc')->get();
        return response(['deliveries' => DeliveryResource::collection($Deliveries)]);
    }

    public function search(Request $request)
    {
        //
        $this->authorize('viewAny', Delivery::class);

        $input=$request->all();
        $delivery = Delivery::where('name','LIKE','%'.$input['searchTerm'].'%')
                        ->orderBy('created_at','asc')
                        ->paginate(20);
        return DeliveryResource::collection($delivery)->preserveQuery();
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
        $this->authorize('create', Delivery::class);

        $input=$request->all();
        $validator = Validator::make($input, [
            'order_id'=>'required',
         ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
          }
        $delivery=Delivery::create($input);
        return new DeliveryResource($delivery);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Delivery $delivery)
    {
        //
        $this->authorize('view', $delivery);

        return new DeliveryResource($delivery);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Delivery $delivery)
    {
        //
        $this->authorize('update', $delivery);

        $input=$request->all();
        $delivery->update($input);
        return new DeliveryResource($delivery);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery $delivery)
    {
        //
        $this->authorize('delete', $delivery);

        $delivery->delete();
        return response(['message' => 'delivery was deleted successfully']);
    }
}