<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Suppliers\Models\Farmer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreFarmerRequest;
use App\Http\Requests\Api\UpdateFarmerRequest;
use App\Http\Resources\V1\FarmerResource;
use Illuminate\Http\JsonResponse;

class FarmerController extends Controller
{
    public function index()
    {
        $farmers = Farmer::query()->withCount('collections')->latest()->paginate(20);

        return FarmerResource::collection($farmers);
    }

    public function store(StoreFarmerRequest $request): FarmerResource
    {
        $farmer = Farmer::query()->create($request->validated());

        return new FarmerResource($farmer);
    }

    public function show(Farmer $farmer): FarmerResource
    {
        $farmer->load(['collections']);

        return new FarmerResource($farmer);
    }

    public function update(UpdateFarmerRequest $request, Farmer $farmer): FarmerResource
    {
        $farmer->update($request->validated());

        return new FarmerResource($farmer->refresh());
    }

    public function destroy(Farmer $farmer): JsonResponse
    {
        $farmer->delete();

        return response()->json(status: 204);
    }
}
