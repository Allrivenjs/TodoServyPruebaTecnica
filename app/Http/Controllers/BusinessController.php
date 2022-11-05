<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeImageRequest;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use App\Http\Requests\StoreBusinessRequest;
use App\Http\Requests\UpdateBusinessRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BusinessController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return ( BusinessResource::collection(Business::with(['user', 'reviews','images'])->get()))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBusinessRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(StoreBusinessRequest $request): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
    {
        return response((new Business)->create($request->validated()), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Business $business
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Business $business): \Illuminate\Http\JsonResponse
    {
        return (new BusinessResource($business->load(['user', 'reviews' => ['user'],'images'])))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBusinessRequest $request
     * @param Business $business
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBusinessRequest $request, Business $business): \Illuminate\Http\Response
    {
        Gate::before(fn()=> $this->isOwner(Auth::user(), $business));
        $business->update($request->validated());
        $this->changeImage($request->file('image'), $business);
        return response(null, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Business $business
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business): \Illuminate\Http\Response
    {
        Gate::before(fn()=> $this->isOwner(Auth::user(), $business));
        $this->deleteImages($business);
        $business->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

}
