<section class="space-y-5">
    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <h3 class="mb-3 text-sm font-semibold text-slate-800"><i class="fas fa-seedling mr-2 text-emerald-600"></i>Collection Officer Dashboard</h3>
        <div class="overflow-auto rounded-xl border border-slate-200">
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
</section>
