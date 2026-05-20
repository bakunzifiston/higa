<section class="grid gap-5 xl:grid-cols-3">
    <div class="space-y-5 xl:col-span-2">
        <script>
        (function(){
          const cb=document.getElementById('adminSupplierShow');
          const box=document.getElementById('adminSupplierBox');
          if(!cb||!box) return;
          box.style.display = cb.checked ? '' : 'none';
          cb.addEventListener('change', ()=>{
            box.style.display = cb.checked ? '' : 'none';
          });
        })();
        </script>


        <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between gap-3 mb-3">
                <h3 class="text-sm font-semibold text-slate-800"><i class="fas fa-seedling mr-2 text-emerald-600"></i>Recent Maize Collections</h3>
                <label class="flex items-center gap-2 text-xs text-slate-600 cursor-pointer select-none">
                    <input type="checkbox" class="peer" id="adminCollectionsShow" checked />
                    Show
                </label>
            </div>
            <div class="overflow-auto rounded-xl border border-slate-200" id="adminCollectionsBox">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-3 py-2 text-left">Farmer</th>
                            <th class="px-3 py-2 text-left">Location</th>
                            <th class="px-3 py-2 text-left">Date</th>
                            <th class="px-3 py-2 text-left">Accepted</th>
                            <th class="px-3 py-2 text-left">Rejected</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentCollections as $c)
                            <tr class="hover:bg-slate-50">
                                <td class="px-3 py-2">{{ optional($c->farmer)->name ?? '-' }}</td>
                                <td class="px-3 py-2">{{ optional($c->location)->name ?? '-' }}</td>
                                <td class="px-3 py-2">{{ $c->collection_date?->format('Y-m-d') ?? '-' }}</td>
                                <td class="px-3 py-2">{{ number_format($c->accepted_quantity ?? 0, 3) }} kg</td>
                                <td class="px-3 py-2">{{ number_format($c->quantity_rejected ?? 0, 3) }} kg</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-3 py-6 text-center text-slate-500">No collections yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <h3 class="mb-3 text-sm font-semibold text-slate-800"><i class="fas fa-receipt mr-2 text-emerald-600"></i>Recent Sales</h3>
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
    </div>

    <div class="space-y-5">
        <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <h3 class="text-sm font-semibold text-slate-800"><i class="fas fa-chart-pie mr-2 text-emerald-600"></i>Production Efficiency</h3>
            <div class="mt-4 flex items-center gap-4">
                <div class="relative h-28 w-28 rounded-full" style="background: {{ $grad }};">
                    <div class="absolute inset-4 grid place-items-center rounded-full bg-white text-lg font-bold text-slate-800">{{ number_format($yield, 0) }}%</div>
                </div>
                <div class="space-y-2 text-sm text-slate-600">
                    <p><span class="inline-block h-2.5 w-2.5 rounded-full bg-emerald-700 mr-2"></span>Yield: {{ number_format($yield, 1) }}%</p>
                    <p><span class="inline-block h-2.5 w-2.5 rounded-full bg-orange-500 mr-2"></span>Wastage: {{ number_format($wastage, 1) }}%</p>
                    @if($emptyPct > 0)
                        <p><span class="inline-block h-2.5 w-2.5 rounded-full bg-slate-300 mr-2"></span>Other: {{ number_format($emptyPct, 1) }}%</p>
                    @endif
                </div>
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <h3 class="mb-3 text-sm font-semibold text-slate-800"><i class="fas fa-warehouse mr-2 text-emerald-600"></i>Raw Stock by Location</h3>
            <div class="space-y-2.5">
                @forelse($report['stock_levels']['raw'] ?? [] as $stock)
                    <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 p-3 text-sm">
                        <div>
                            <p class="font-semibold text-slate-800">Warehouse {{ $stock->location_id }}</p>
                            <p class="text-xs text-slate-500">Raw maize inventory</p>
                        </div>
                        <p class="font-semibold text-emerald-700">{{ number_format($stock->quantity ?? 0, 3) }} kg</p>
                    </div>
                @empty
                    <p class="rounded-xl border border-dashed border-slate-300 p-4 text-center text-sm text-slate-500">No raw stock data.</p>
                @endforelse
            </div>
        </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between gap-3 mb-2">
                <h3 class="mb-0 text-sm font-semibold text-slate-800"><i class="fas fa-tractor mr-2 text-emerald-600"></i>Top Supplier Performance</h3>
                <label class="flex items-center gap-2 text-xs text-slate-600 cursor-pointer select-none">
                    <input type="checkbox" id="adminSupplierShow" checked />
                    Show
                </label>
            </div>

            <div class="space-y-2.5" id="adminSupplierBoxInner">

                @forelse($report['supplier_performance'] ?? [] as $sp)
                    <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 p-3 text-sm">
                        <div>
                            <p class="font-semibold text-slate-800">Supplier {{ $sp->farmer_id }}</p>
                            <p class="text-xs text-slate-500">Accepted {{ number_format($sp->total_accepted ?? 0, 3) }} kg</p>
                        </div>
                        <p class="font-semibold text-orange-600">{{ number_format($sp->total_rejected ?? 0, 3) }} rejected</p>
                    </div>
                @empty
                    <p class="rounded-xl border border-dashed border-slate-300 p-4 text-center text-sm text-slate-500">No supplier data.</p>
                @endforelse
            </div>

            <style>
                /* compact scroller so admin dashboard stays readable */
                #adminSupplierBox{max-height:260px;overflow:auto;}
                @media (min-width:1024px){ #adminSupplierBox{max-height:220px;} }
            </style>
        </section>


    </div>
</section>


