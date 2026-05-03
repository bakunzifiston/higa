<?php

namespace App\Http\Controllers;

use App\Domain\Collections\Models\MaizeCollection;
use App\Domain\Finance\Models\Payment;
use App\Domain\Inventory\Models\FinishedInventoryMovement;
use App\Domain\Inventory\Models\Location;
use App\Domain\Inventory\Models\Product;
use App\Domain\Inventory\Models\RawInventoryMovement;
use App\Domain\Production\Models\ProductionBatch;
use App\Domain\Reporting\Services\DashboardService;
use App\Domain\Sales\Models\Sale;
use App\Domain\Sales\Models\SaleReturn;
use App\Domain\Suppliers\Models\Farmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboardService,
    ) {
    }

public function __invoke(Request $request): View
    {
        set_time_limit(60);

        $user = auth()->user();
        $roleSlug = $user?->role?->slug ?? 'admin';

        $dbError = null;
        $stats = [];
        $kpis = [];
        $report = [];
        $recentCollections = collect();
        $recentSales = collect();

        try {
            // Role-based stats query
            $statsQuery = match ($roleSlug) {
                'collection-officer' => "
                    SELECT
                        (SELECT COUNT(*) FROM farmers) as farmers,
                        (SELECT COUNT(*) FROM locations) as locations,
                        (SELECT COUNT(*) FROM maize_collections) as collections,
                        0 as products, 0 as production_batches, 0 as sales
                ",
                'production-manager' => "
                    SELECT
                        0 as farmers, 0 as locations, 0 as collections,
                        (SELECT COUNT(*) FROM products) as products,
                        (SELECT COUNT(*) FROM production_batches) as production_batches,
                        0 as sales
                ",
                'sales-team' => "
                    SELECT
                        0 as farmers, 0 as locations, 0 as collections,
                        (SELECT COUNT(*) FROM products) as products,
                        0 as production_batches,
                        (SELECT COUNT(*) FROM sales) as sales
                ",
                default => "
                    SELECT
                        (SELECT COUNT(*) FROM farmers) as farmers,
                        (SELECT COUNT(*) FROM locations) as locations,
                        (SELECT COUNT(*) FROM maize_collections) as collections,
                        (SELECT COUNT(*) FROM products) as products,
                        (SELECT COUNT(*) FROM production_batches) as production_batches,
                        (SELECT COUNT(*) FROM sales) as sales
                ",
            };
            $counts = DB::select($statsQuery);
            $stats = (array) $counts[0];
        } catch (Throwable $e) {
            Log::error('Dashboard stats query failed: ' . $e->getMessage());
            $dbError = 'Database connection error. Please check your DB_CONNECTION and database server.';
            $stats = array_fill_keys(['farmers','locations','collections','products','production_batches','sales'], 0);
        }

// Use ImsMenu for role-based menu filtering
        $menuItems = \App\Support\ImsMenu::moduleNav($user);
        
        // Add Users link for admins only (if not already in filtered list)
        if (auth()->check() && auth()->user()->isAdmin()) {
            $hasUsers = collect($menuItems)->contains('slug', 'users');
            if (!$hasUsers) {
                $menuItems[] = ['slug' => 'users', 'label' => 'Users', 'href' => route('users.index'), 'icon' => 'fa-users'];
            }
        }

        $activeModule = $request->query('module', 'dashboard');
        $currentModule = collect($menuItems)->firstWhere('slug', $activeModule)
            ?? $menuItems[0];

        if ($dbError === null) {
            try {
                $kpiData = DB::select("
                    SELECT
                        (SELECT COALESCE(SUM(CASE WHEN type='IN' THEN quantity ELSE -quantity END),0) FROM raw_inventory_movements) as raw_stock,
                        (SELECT COALESCE(SUM(CASE WHEN type='IN' THEN quantity ELSE -quantity END),0) FROM finished_inventory_movements) as finished_stock,
                        (SELECT COALESCE(SUM(total_amount),0) FROM sales) as sales_revenue,
                        (SELECT COALESCE(SUM(amount),0) FROM payments) as payments_collected,
                        (SELECT COALESCE(SUM(accepted_quantity),0) FROM maize_collections) as maize_accepted,
                        (SELECT COALESCE(SUM(maize_used),0) FROM production_batches) as maize_used,
                        (SELECT COALESCE(SUM(wastage_quantity),0) FROM production_batches) as wastage_kg,
                        (SELECT COALESCE(SUM(quantity),0) FROM sale_returns) as returns_kg
                ")[0];

                $rawStockKg = (float) $kpiData->raw_stock;
                $finishedStockKg = (float) $kpiData->finished_stock;
                $salesRevenue = (float) $kpiData->sales_revenue;
                $paymentsCollected = (float) $kpiData->payments_collected;
                $outstanding = max(0, $salesRevenue - $paymentsCollected);
                $maizeAccepted = (float) $kpiData->maize_accepted;
                $maizeUsed = (float) $kpiData->maize_used;
                $wastageKg = (float) $kpiData->wastage_kg;
                $returnsKg = (float) $kpiData->returns_kg;
                $productionEfficiency = $maizeUsed > 0 ? ($maizeUsed - $wastageKg) / $maizeUsed * 100 : 0.0;

// Role-specific KPIs
                $kpis = match ($roleSlug) {
                    'collection-officer' => [
                        ['label' => 'Farmers', 'value' => number_format($stats['farmers']), 'sub' => 'Active suppliers'],
                        ['label' => 'Warehouses', 'value' => number_format($stats['locations']), 'sub' => 'Storage locations'],
                        ['label' => 'Collections', 'value' => number_format($stats['collections']), 'sub' => 'Total collections'],
                        ['label' => 'Maize Accepted', 'value' => number_format($maizeAccepted, 3) . ' kg', 'sub' => 'Total accepted'],
                        ['label' => 'Raw Stock', 'value' => number_format($rawStockKg, 3) . ' kg', 'sub' => 'In raw inventory'],
                    ],
                    'production-manager' => [
                        ['label' => 'Products', 'value' => number_format($stats['products']), 'sub' => 'Product catalog'],
                        ['label' => 'Raw Stock', 'value' => number_format($rawStockKg, 3) . ' kg', 'sub' => 'Available maize'],
                        ['label' => 'Batches', 'value' => number_format($stats['production_batches']), 'sub' => 'Total processed'],
                        ['label' => 'Efficiency', 'value' => number_format($productionEfficiency, 2) . '%', 'sub' => 'Yield rate'],
                        ['label' => 'Wastage', 'value' => number_format($wastageKg, 3) . ' kg', 'sub' => 'Total loss'],
                        ['label' => 'Finished Stock', 'value' => number_format($finishedStockKg, 3) . ' kg', 'sub' => 'Finished goods'],
                    ],
                    'sales-team' => [
                        ['label' => 'Products', 'value' => number_format($stats['products']), 'sub' => 'Available stock'],
                        ['label' => 'Sales', 'value' => number_format($stats['sales']), 'sub' => 'Total orders'],
                        ['label' => 'Revenue', 'value' => 'RWF ' . number_format($salesRevenue, 2), 'sub' => 'Total sales'],
                        ['label' => 'Collected', 'value' => 'RWF ' . number_format($paymentsCollected, 2), 'sub' => 'Payments received'],
                        ['label' => 'Outstanding', 'value' => 'RWF ' . number_format($outstanding, 2), 'sub' => 'Pending payment'],
                        ['label' => 'Returns', 'value' => number_format($returnsKg, 3) . ' kg', 'sub' => 'Returned goods'],
                    ],
                    default => [
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
                    ],
                };

$report = $this->dashboardService->build($roleSlug);

                // Role-based recent data
                $recentCollections = match ($roleSlug) {
                    'collection-officer', 'admin' => MaizeCollection::query()
                        ->with(['farmer', 'location'])
                        ->latest('collection_date')
                        ->limit(5)
                        ->get(),
                    default => collect(),
                };

                $recentSales = match ($roleSlug) {
                    'sales-team', 'admin' => Sale::query()
                        ->with('items')
                        ->latest('sale_date')
                        ->limit(5)
                        ->get(),
                    default => collect(),
                };
            } catch (Throwable $e) {
                Log::error('Dashboard data query failed: ' . $e->getMessage());
                $dbError = 'Database query timeout. Please check your database connection or increase max_execution_time.';
                $kpis = [];
                $report = [];
            }
        }

return view('dashboard', [
            'stats' => $stats,
            'kpis' => $kpis,
            'menuItems' => $menuItems,
            'activeModule' => $currentModule['slug'],
            'currentModule' => $currentModule,
            'report' => $report,
            'recentCollections' => $recentCollections,
            'recentSales' => $recentSales,
            'dbError' => $dbError,
            'roleSlug' => $roleSlug,
        ]);
    }
}
