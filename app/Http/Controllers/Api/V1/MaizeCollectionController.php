<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Collections\Models\MaizeCollection;
use App\Domain\Collections\Services\MaizeCollectionService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreMaizeCollectionRequest;
use App\Http\Resources\V1\MaizeCollectionResource;

class MaizeCollectionController extends Controller
{
    public function __construct(private readonly MaizeCollectionService $collectionService)
    {
    }

    public function index()
    {
        $collections = MaizeCollection::query()->with(['farmer', 'location'])->latest('collection_date')->paginate(20);

        return MaizeCollectionResource::collection($collections);
    }

    public function store(StoreMaizeCollectionRequest $request): MaizeCollectionResource
    {
        $collection = $this->collectionService->record($request->validated());

        return new MaizeCollectionResource($collection->load(['farmer', 'location']));
    }

    public function show(MaizeCollection $maizeCollection): MaizeCollectionResource
    {
        return new MaizeCollectionResource($maizeCollection->load(['farmer', 'location']));
    }
}
