<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Inventory\Models\ProductPackage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProductPackageRequest;
use App\Http\Requests\Api\UpdateProductPackageRequest;
use App\Http\Resources\V1\ProductPackageResource;
use Illuminate\Http\JsonResponse;

class ProductPackageController extends Controller
{
    public function index()
    {
        return ProductPackageResource::collection(ProductPackage::query()->latest()->paginate(20));
    }

    public function store(StoreProductPackageRequest $request): ProductPackageResource
    {
        $package = ProductPackage::query()->create($request->validated());

        return new ProductPackageResource($package);
    }

    public function show(ProductPackage $productPackage): ProductPackageResource
    {
        return new ProductPackageResource($productPackage);
    }

    public function update(UpdateProductPackageRequest $request, ProductPackage $productPackage): ProductPackageResource
    {
        $productPackage->update($request->validated());

        return new ProductPackageResource($productPackage->refresh());
    }

    public function destroy(ProductPackage $productPackage): JsonResponse
    {
        $productPackage->delete();

        return response()->json(status: 204);
    }
}
