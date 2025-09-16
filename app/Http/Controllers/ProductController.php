<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->authorize('viewAny', Product::class);

        $products = Product::orderBy('created_at','desc')->paginate(20);
        return ProductResource::collection($products)->preserveQuery();
    }

    public function products()
    {
        //
        $this->authorize('viewAny', Product::class);

        $products = Product::orderBy('created_at','asc')->get();
        return response(['products' => ProductResource::collection($products)]);
    }

    public function search(Request $request)
    {
        //
        $this->authorize('viewAny', Product::class);

        $input=$request->all();
        $product = Product::where('name','LIKE','%'.$input['searchTerm'].'%')
                        ->orderBy('created_at','asc')
                        ->paginate(20);
        return ProductResource::collection($product)->preserveQuery();
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
        $this->authorize('create', Product::class);

        $input=$request->all();
        $validator = Validator::make($input, [
            'category_id'=>'required',
         ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
          }
        $product=Product::create($input);
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        $this->authorize('view', $product);

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $this->authorize('update', $product);

        $input=$request->all();
        $product->update($input);
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $this->authorize('delete', $product);

        $product->delete();
        return response(['message' => 'product was deleted successfully']);
    }
}