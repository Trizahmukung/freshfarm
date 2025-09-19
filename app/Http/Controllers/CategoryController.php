<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->authorize('viewAny', Category::class);

        $categories = Category::orderBy('created_at','desc')->paginate(20);
        return CategoryResource::collection($categories)->preserveQuery();
    }

    public function categories()
    {
        //
        $this->authorize('viewAny', Category::class);

        $categories = Category::orderBy('created_at','asc')->get();
        return response(['categories' => CategoryResource::collection($categories)]);
    }

    public function search(Request $request)
    {
        //
        $this->authorize('viewAny', Category::class);

        $input=$request->all();
        $category = Category::where('name','LIKE','%'.$input['searchTerm'].'%')
                        ->orderBy('created_at','asc')
                        ->paginate(20);
        return CategoryResource::collection($category)->preserveQuery();
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
        $this->authorize('create', Category::class);

        $input=$request->all();
        $validator = Validator::make($input, [
            'description'=>'required',
         ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
          }
        $category=Category::create($input);
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
        $this->authorize('view', $category);

        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        $this->authorize('update', $category);

        $input=$request->all();
        $category->update($input);
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        $this->authorize('delete', $category);

        $category->delete();
        return response(['message' => 'category was deleted successfully']);
    }
}