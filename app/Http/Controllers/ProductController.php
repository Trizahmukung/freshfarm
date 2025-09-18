<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $this->authorize('viewAny', Product::class);

        $products = Product::orderBy('created_at','desc')->paginate(20);
        return ProductResource::collection($products)->preserveQuery();
    }

    public function products()
    {
        $this->authorize('viewAny', Product::class);

        $products = Product::orderBy('created_at','asc')->get();
        return response(['products' => ProductResource::collection($products)]);
    }

    public function search(Request $request)
    {
        $this->authorize('viewAny', Product::class);

        $input = $request->all();
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
        // $this->authorize('create', Product::class);

        $input = $request->all();
        
        // Enhanced validation
        $validator = Validator::make($input, [
            'farm_id' => 'required|exists:farms,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'stock_quantity' => 'required|integer|min:0',
            'harvest_date' => 'nullable|date',
            'is_available' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
        }

        // Auto-generate slug if not provided
        if (empty($input['slug'])) {
            $input['slug'] = Str::slug($input['name']);
            
            // Ensure slug is unique
            $originalSlug = $input['slug'];
            $counter = 1;
            while (Product::where('slug', $input['slug'])->exists()) {
                $input['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $product = Product::create($input);
        
        return response([
            'message' => 'Product created successfully',
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
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
        $this->authorize('update', $product);

        $input = $request->all();
        
        // Enhanced validation for update
        $validator = Validator::make($input, [
            'farm_id' => 'sometimes|exists:farms,id',
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'unit' => 'sometimes|string|max:50',
            'stock_quantity' => 'sometimes|integer|min:0',
            'harvest_date' => 'nullable|date',
            'is_available' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
        }

        $product->update($input);
        
        return response([
            'message' => 'Product updated successfully',
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $product->delete();
        return response(['message' => 'Product deleted successfully']);
    }
}