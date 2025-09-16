<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Http\Resources\OrderItemResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->authorize('viewAny', OrderItem::class);

        $orderitems = OrderItem::orderBy('created_at','desc')->paginate(20);
        return OrderItemResource::collection($orderitems)->preserveQuery();
    }

    public function orderitems()
    {
        //
        $this->authorize('viewAny', OrderItem::class);

        $orderitems = OrderItem::orderBy('created_at','asc')->get();
        return response(['orderitems' => OrderItemResource::collection($orderitems)]);
    }

    public function search(Request $request)
    {
        //
        $this->authorize('viewAny', OrderItem::class);

        $input=$request->all();
        $orderitem = OrderItem::where('name','LIKE','%'.$input['searchTerm'].'%')
                        ->orderBy('created_at','asc')
                        ->paginate(20);
        return OrderItemResource::collection($orderitem)->preserveQuery();
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
        $this->authorize('create', OrderItem::class);

        $input=$request->all();
        $validator = Validator::make($input, [
            'product_id'=>'required',
         ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
          }
        $orderitem=OrderItem::create($input);
        return new OrderItemResource($orderitem);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderItem  $orderitem
     * @return \Illuminate\Http\Response
     */
    public function show(OrderItem $orderitem)
    {
        //
        $this->authorize('view', $orderitem);

        return new OrderItemResource($orderitem);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderItem  $orderitem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderItem $orderitem)
    {
        //
        $this->authorize('update', $orderitem);

        $input=$request->all();
        $orderitem->update($input);
        return new OrderItemResource($orderitem);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderItem  $orderitem
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderItem $orderitem)
    {
        //
        $this->authorize('delete', $orderitem);

        $orderitem->delete();
        return response(['message' => 'orderitem was deleted successfully']);
    }
}