<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeImageRequest;
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
     * @return \Illuminate\Http\Response
     */
    public function index(): \Illuminate\Http\Response
    {
        return response(Business::with(['user', 'reviews','images'])->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBusinessRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBusinessRequest $request): \Illuminate\Http\Response
    {
        return response((new Business)->create($request->validated()), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Business $business
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business): \Illuminate\Http\Response
    {
        return response($business->load(['user', 'reviews','images']));
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

    public function updateImage(ChangeImageRequest $request, Business $business): \Illuminate\Http\Response
    {
        Gate::before(fn()=> $this->isOwner(Auth::user(), $business));
        $request->validated();
        $this->changeImage($request->file('image'), $business);
        return response(null, Response::HTTP_ACCEPTED);
    }
}
