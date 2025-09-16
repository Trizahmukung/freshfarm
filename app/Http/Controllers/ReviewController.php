<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Resources\ReviewResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->authorize('viewAny', Review::class);

        $reviews = Review::orderBy('created_at','desc')->paginate(20);
        return ReviewResource::collection($reviews)->preserveQuery();
    }

    public function reviews()
    {
        //
        $this->authorize('viewAny', Review::class);

        $reviews = Review::orderBy('created_at','asc')->get();
        return response(['reviews' => ReviewResource::collection($reviews)]);
    }

    public function search(Request $request)
    {
        //
        $this->authorize('viewAny', Review::class);

        $input=$request->all();
        $review = Review::where('name','LIKE','%'.$input['searchTerm'].'%')
                        ->orderBy('created_at','asc')
                        ->paginate(20);
        return ReviewResource::collection($review)->preserveQuery();
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
        $this->authorize('create', Review::class);

        $input=$request->all();
        $validator = Validator::make($input, [
            'rating'=>'required',
         ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
          }
        $review=Review::create($input);
        return new ReviewResource($review);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
        $this->authorize('view', $review);

        return new ReviewResource($review);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
        $this->authorize('update', $review);

        $input=$request->all();
        $review->update($input);
        return new ReviewResource($review);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
        $this->authorize('delete', $review);

        $review->delete();
        return response(['message' => 'review was deleted successfully']);
    }
}