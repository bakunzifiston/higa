<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Inventory\Models\Location;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreLocationRequest;
use App\Http\Requests\Api\UpdateLocationRequest;
use App\Http\Resources\V1\LocationResource;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    public function index()
    {
        return LocationResource::collection(Location::query()->latest()->paginate(20));
    }

    public function store(StoreLocationRequest $request): LocationResource
    {
        $location = Location::query()->create($request->validated());

        return new LocationResource($location);
    }

    public function show(Location $location): LocationResource
    {
        return new LocationResource($location);
    }

    public function update(UpdateLocationRequest $request, Location $location): LocationResource
    {
        $location->update($request->validated());

        return new LocationResource($location->refresh());
    }

    public function destroy(Location $location): JsonResponse
    {
        $location->delete();

        return response()->json(status: 204);
    }
}
