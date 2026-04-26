<?php

namespace App\Domain\Finance\Services;

use App\Domain\Finance\Models\Payment;
use App\Domain\Sales\Models\Sale;
use DomainException;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function recordPayment(array $data): Payment
    {
        return DB::transaction(function () use ($data) {
            $sale = Sale::query()->findOrFail($data['sale_id']);

            $alreadyPaid = (float) Payment::query()
                ->where('sale_id', $sale->id)
                ->sum('amount');

            $incoming = (float) $data['amount'];
            $saleTotal = (float) $sale->total_amount;

            if ($incoming <= 0) {
                throw new DomainException('Payment amount must be greater than zero.');
            }

            if (($alreadyPaid + $incoming) - $saleTotal > 0.001) {
                throw new DomainException('Payment exceeds outstanding sale balance.');
            }

            return Payment::query()->create([
                'sale_id' => $sale->id,
                'amount' => $incoming,
                'payment_method' => $data['payment_method'],
                'reference' => $data['reference'] ?? null,
                'payment_date' => $data['payment_date'],
            ]);
        });
    }
}
