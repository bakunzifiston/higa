<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Inventory\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProductRequest;
use App\Http\Requests\Api\UpdateProductRequest;
use App\Http\Resources\V1\ProductResource;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index()
    {
        return ProductResource::collection(Product::query()->with('packages')->latest()->paginate(20));
    }

    public function store(StoreProductRequest $request): ProductResource
    {
        $product = Product::query()->create($request->validated());

        return new ProductResource($product);
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product->load('packages'));
    }

    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        $product->update($request->validated());

        return new ProductResource($product->refresh()->load('packages'));
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(status: 204);
    }
}
