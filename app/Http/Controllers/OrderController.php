<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->authorize('viewAny', Order::class);

        $orders = Order::orderBy('created_at','desc')->paginate(20);
        return OrderResource::collection($orders)->preserveQuery();
    }

    public function orders()
    {
        //
        $this->authorize('viewAny', Order::class);

        $orders = Order::orderBy('created_at','asc')->get();
        return response(['orders' => OrderResource::collection($orders)]);
    }

    public function search(Request $request)
    {
        //
        $this->authorize('viewAny', Order::class);

        $input=$request->all();
        $order = Order::where('name','LIKE','%'.$input['searchTerm'].'%')
                        ->orderBy('created_at','asc')
                        ->paginate(20);
        return OrderResource::collection($order)->preserveQuery();
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
        $this->authorize('create', Order::class);

        $input=$request->all();
        $validator = Validator::make($input, [
            'name'=>'required',
         ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
          }
        $order=Order::create($input);
        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
        $this->authorize('view', $order);

        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
        $this->authorize('update', $order);

        $input=$request->all();
        $order->update($input);
        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
        $this->authorize('delete', $order);

        $order->delete();
        return response(['message' => 'order was deleted successfully']);
    }
}