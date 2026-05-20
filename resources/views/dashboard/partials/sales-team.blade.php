<section class="space-y-5">
    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <h3 class="mb-3 text-sm font-semibold text-slate-800"><i class="fas fa-receipt mr-2 text-emerald-600"></i>Sales Team Dashboard</h3>
        <div class="overflow-auto rounded-xl border border-slate-200">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-3 py-2 text-left">Invoice</th>
                        <th class="px-3 py-2 text-left">Customer</th>
                        <th class="px-3 py-2 text-left">Date</th>
                        <th class="px-3 py-2 text-left">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentSales as $s)
                        <tr class="hover:bg-slate-50">
                            <td class="px-3 py-2">{{ $s->invoice_number }}</td>
                            <td class="px-3 py-2">{{ $s->customer_name }}</td>
                            <td class="px-3 py-2">{{ $s->sale_date?->format('Y-m-d') ?? '-' }}</td>
                            <td class="px-3 py-2">RWF {{ number_format($s->total_amount ?? 0, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-3 py-6 text-center text-slate-500">No sales yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</section>
