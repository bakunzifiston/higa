<?php

namespace App\Http\Controllers;

use App\Domain\Collections\Models\MaizeCollection;
use App\Domain\Finance\Models\Payment;
use App\Domain\Inventory\Models\FinishedInventoryMovement;
use App\Domain\Inventory\Models\Location;
use App\Domain\Inventory\Models\Product;
use App\Domain\Inventory\Models\RawInventoryMovement;
use App\Domain\Production\Models\ProductionBatch;
use App\Domain\Sales\Models\Sale;
use App\Domain\Sales\Models\SaleReturn;
use App\Domain\Suppliers\Models\Farmer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $stats = [
            'farmers' => Farmer::query()->count(),
            'locations' => Location::query()->count(),
            'collections' => MaizeCollection::query()->count(),
            'products' => Product::query()->count(),
            'production_batches' => ProductionBatch::query()->count(),
            'sales' => Sale::query()->count(),
        ];

        $menuItems = [
            ['slug' => 'dashboard', 'label' => 'Dashboard', 'endpoint' => '/dashboard', 'metric' => $stats['sales']],
            ['slug' => 'farmers', 'label' => 'Farmers', 'endpoint' => '/modules/farmers', 'metric' => $stats['farmers']],
            ['slug' => 'locations', 'label' => 'Locations', 'endpoint' => '/modules/locations', 'metric' => $stats['locations']],
            ['slug' => 'collections', 'label' => 'Collections', 'endpoint' => '/modules/collections', 'metric' => $stats['collections']],
            ['slug' => 'raw-inventory', 'label' => 'Raw Inventory', 'endpoint' => '/modules/raw-inventory', 'metric' => $stats['collections']],
            ['slug' => 'production', 'label' => 'Production', 'endpoint' => '/modules/production', 'metric' => $stats['production_batches']],
            ['slug' => 'products', 'label' => 'Products', 'endpoint' => '/modules/products', 'metric' => $stats['products']],
            ['slug' => 'finished-inventory', 'label' => 'Finished Inventory', 'endpoint' => '/modules/finished-inventory', 'metric' => $stats['production_batches']],
            ['slug' => 'sales', 'label' => 'Sales', 'endpoint' => '/modules/sales', 'metric' => $stats['sales']],
            ['slug' => 'returns', 'label' => 'Returns', 'endpoint' => '/modules/returns', 'metric' => $stats['sales']],
            ['slug' => 'expenses', 'label' => 'Expenses', 'endpoint' => '/modules/expenses', 'metric' => $stats['production_batches']],
            ['slug' => 'payments', 'label' => 'Payments', 'endpoint' => '/modules/payments', 'metric' => $stats['sales']],
            ['slug' => 'profile', 'label' => 'Profile', 'endpoint' => route('profile.edit'), 'metric' => '—'],
        ];

        $activeModule = $request->query('module', 'dashboard');
        $currentModule = collect($menuItems)->firstWhere('slug', $activeModule)
            ?? $menuItems[0];

        $rawStockKg = (float) RawInventoryMovement::query()
            ->selectRaw("COALESCE(SUM(CASE WHEN type='IN' THEN quantity ELSE -quantity END),0) as stock")
            ->value('stock');

        $finishedStockKg = (float) FinishedInventoryMovement::query()
            ->selectRaw("COALESCE(SUM(CASE WHEN type='IN' THEN quantity ELSE -quantity END),0) as stock")
            ->value('stock');

        $salesRevenue = (float) Sale::query()->sum('total_amount');
        $paymentsCollected = (float) Payment::query()->sum('amount');
        $outstanding = max(0, $salesRevenue - $paymentsCollected);
        $maizeAccepted = (float) MaizeCollection::query()->sum('accepted_quantity');
        $maizeUsed = (float) ProductionBatch::query()->sum('maize_used');
        $wastageKg = (float) ProductionBatch::query()->sum('wastage_quantity');
        $returnsKg = (float) SaleReturn::query()->sum('quantity');
        $productionEfficiency = $maizeUsed > 0 ? ($maizeUsed - $wastageKg) / $maizeUsed * 100 : 0.0;

        $kpis = [
            ['label' => 'Farmers', 'value' => number_format($stats['farmers']), 'sub' => 'Suppliers'],
            ['label' => 'Maize Accepted', 'value' => number_format($maizeAccepted, 3) . ' kg', 'sub' => 'Collections module'],
            ['label' => 'Raw Stock', 'value' => number_format($rawStockKg, 3) . ' kg', 'sub' => 'Raw inventory ledger'],
            ['label' => 'Finished Stock', 'value' => number_format($finishedStockKg, 3) . ' kg', 'sub' => 'Finished inventory ledger'],
            ['label' => 'Production Batches', 'value' => number_format($stats['production_batches']), 'sub' => 'Batch processing'],
            ['label' => 'Production Efficiency', 'value' => number_format($productionEfficiency, 2) . '%', 'sub' => 'From maize usage'],
            ['label' => 'Sales Revenue', 'value' => 'RWF ' . number_format($salesRevenue, 2), 'sub' => 'Sales module'],
            ['label' => 'Outstanding Balance', 'value' => 'RWF ' . number_format($outstanding, 2), 'sub' => 'Sales - payments'],
            ['label' => 'Returns Quantity', 'value' => number_format($returnsKg, 3) . ' kg', 'sub' => 'Returns module'],
            ['label' => 'Payments Collected', 'value' => 'RWF ' . number_format($paymentsCollected, 2), 'sub' => 'Payments module'],
        ];

        return view('dashboard', [
            'stats' => $stats,
            'kpis' => $kpis,
            'menuItems' => $menuItems,
            'activeModule' => $currentModule['slug'],
            'currentModule' => $currentModule,
        ]);
    }
}
