<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Finance\Models\Payment;
use App\Domain\Finance\Services\PaymentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePaymentRequest;
use App\Http\Resources\V1\PaymentResource;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private readonly PaymentService $paymentService)
    {
    }

    public function store(StorePaymentRequest $request): PaymentResource
    {
        $payment = $this->paymentService->recordPayment($request->validated());

        return new PaymentResource($payment);
    }

    public function index(Request $request)
    {
        $query = Payment::query()->latest('payment_date');

        if ($request->filled('sale_id')) {
            $query->where('sale_id', $request->integer('sale_id'));
        }

        return PaymentResource::collection($query->paginate(50));
    }
}
