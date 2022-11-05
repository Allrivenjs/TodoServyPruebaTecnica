<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use App\Http\Requests\StoreReviewsRequest;
use App\Http\Requests\UpdateReviewsRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ReviewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id): \Illuminate\Http\Response
    {
        return response(Reviews::query()->with('user')->where('business_id', $id)->get(), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreReviewsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReviewsRequest $request): \Illuminate\Http\Response
    {
        return response(Reviews::query()->create(array_merge($request->validated(), ['user_id'=>Auth::id()])), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Reviews $reviews
     * @return \Illuminate\Http\Response
     */
    public function show(Reviews $reviews): \Illuminate\Http\Response
    {
        return response($reviews->load(['user', 'business']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReviewsRequest $request
     * @param Reviews $reviews
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReviewsRequest $request, Reviews $reviews): \Illuminate\Http\Response
    {
        Gate::before(fn()=> $this->isOwner(Auth::user(), $reviews));
        return response($reviews->update($request->validated()), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($reviews): \Illuminate\Http\Response
    {
        Gate::before(fn()=> $this->isOwner(Auth::user(), $reviews));
        $r = Reviews::query()->find($reviews);
        if (!$r) {
            return response(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        }
        $r->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
