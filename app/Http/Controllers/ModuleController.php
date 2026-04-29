<?php

namespace App\Http\Controllers;

use App\Domain\Collections\Models\MaizeCollection;
use App\Domain\Collections\Services\MaizeCollectionService;
use App\Domain\Finance\Models\Payment;
use App\Domain\Finance\Services\PaymentService;
use App\Domain\Inventory\Models\FinishedInventoryMovement;
use App\Domain\Inventory\Models\Location;
use App\Domain\Inventory\Models\Product;
use App\Domain\Inventory\Models\ProductPackage;
use App\Domain\Inventory\Models\RawInventoryMovement;
use App\Domain\Production\Models\BatchExpense;
use App\Domain\Production\Models\ProductionBatch;
use App\Domain\Production\Services\BatchExpenseService;
use App\Domain\Production\Services\ProductionService;
use App\Domain\Sales\Models\Sale;
use App\Domain\Sales\Models\SaleItem;
use App\Domain\Sales\Models\SaleReturn;
use App\Domain\Sales\Services\SalesReturnService;
use App\Domain\Sales\Services\SalesService;
use App\Domain\Suppliers\Models\Farmer;
use App\Support\ImsMenu;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ModuleController extends Controller
{
    public function __construct(
        private readonly MaizeCollectionService $maizeCollectionService,
        private readonly ProductionService $productionService,
        private readonly SalesService $salesService,
        private readonly SalesReturnService $salesReturnService,
        private readonly BatchExpenseService $batchExpenseService,
        private readonly PaymentService $paymentService,
    ) {
    }

    public function show(string $module): View
    {
        abort_unless(in_array($module, $this->allowedModules(), true), 404);

        [$stats, $menuItems] = $this->dashboardData($module);

        return view('modules.index', [
            'module' => $module,
            'navActive' => $module,
            'stats' => $stats,
            'menuItems' => $menuItems,
            'records' => $this->recordsForModule($module),
            'lookups' => $this->lookupData(),
            'editRecord' => null,
        ]);
    }

    public function edit(string $module, int $id): View
    {
        abort_unless(in_array($module, ['farmers', 'locations', 'products', 'collections'], true), 404);

        [$stats, $menuItems] = $this->dashboardData($module);

        $editRecord = match ($module) {
            'farmers' => Farmer::query()->findOrFail($id),
            'locations' => Location::query()->findOrFail($id),
            'products' => Product::query()->findOrFail($id),
            'collections' => MaizeCollection::query()->findOrFail($id),
        };

        return view('modules.index', [
            'module' => $module,
            'navActive' => $module,
            'stats' => $stats,
            'menuItems' => $menuItems,
            'records' => $this->recordsForModule($module),
            'lookups' => $this->lookupData(),
            'editRecord' => $editRecord,
        ]);
    }

    public function store(Request $request, string $module): RedirectResponse
    {
        abort_unless(in_array($module, $this->allowedModules(), true), 404);

        try {
            match ($module) {
                'farmers' => Farmer::query()->create($request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'phone' => ['required', 'string', 'max:40', 'unique:farmers,phone'],
                    'country' => ['required', 'string', 'max:120'],
                    'province' => ['required', 'string', 'max:120'],
                    'district' => ['required', 'string', 'max:120'],
                    'sector' => ['required', 'string', 'max:120'],
                    'cell' => ['required', 'string', 'max:120'],
                    'village' => ['required', 'string', 'max:120'],
                ])),
                'locations' => Location::query()->create($request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'code' => ['required', 'string', 'max:80', 'unique:locations,code'],
                    'country' => ['required', 'string', 'max:120'],
                    'province' => ['required', 'string', 'max:120'],
                    'district' => ['required', 'string', 'max:120'],
                    'sector' => ['required', 'string', 'max:120'],
                    'cell' => ['required', 'string', 'max:120'],
                    'village' => ['required', 'string', 'max:120'],
                    'is_active' => ['nullable', 'boolean'],
                ])),
'collections' => $this->maizeCollectionService->record($request->validate([
                    'farmer_id' => ['required', 'integer', 'exists:farmers,id'],
                    'location_id' => ['required', 'integer', 'exists:locations,id'],
                    'product_name' => ['nullable', 'string', 'max:255'],
                    'collection_date' => ['required', 'date'],
                    'quantity_collected' => ['required', 'numeric', 'gt:0'],
                    'quantity_rejected' => ['nullable', 'numeric', 'gte:0'],
                    'rejection_reason' => ['nullable', 'string'],
                    'price_per_kg' => ['required', 'numeric', 'gt:0'],
                ])),
                'products' => Product::query()->create($request->validate([
                    'name' => ['required', 'string', 'max:255', 'unique:products,name'],
                    'sku' => ['required', 'string', 'max:120', 'unique:products,sku'],
                    'is_active' => ['nullable', 'boolean'],
                ])),
                'production' => $this->createProductionBatch($request),
                'sales' => $this->createSale($request),
                'returns' => $this->salesReturnService->processReturn($request->validate([
                    'sale_id' => ['required', 'integer', 'exists:sales,id'],
                    'sale_item_id' => ['required', 'integer', 'exists:sale_items,id'],
                    'quantity' => ['required', 'numeric', 'gt:0'],
                    'reason' => ['required', 'string', 'max:255'],
                    'return_date' => ['required', 'date'],
                ])),
                'expenses' => $this->batchExpenseService->addExpense($request->validate([
                    'production_batch_id' => ['required', 'integer', 'exists:production_batches,id'],
                    'type' => ['required', Rule::in(['labor', 'transport', 'packaging', 'utilities'])],
                    'amount' => ['required', 'numeric', 'gt:0'],
                    'description' => ['nullable', 'string', 'max:255'],
                ])),
                'payments' => $this->paymentService->recordPayment($request->validate([
                    'sale_id' => ['required', 'integer', 'exists:sales,id'],
                    'amount' => ['required', 'numeric', 'gt:0'],
                    'payment_method' => ['required', Rule::in(['cash', 'mobile_money', 'bank_transfer', 'credit'])],
                    'reference' => ['nullable', 'string', 'max:100'],
                    'payment_date' => ['required', 'date'],
                ])),
                default => null,
            };
        } catch (DomainException $exception) {
            return back()->withErrors(['module' => $exception->getMessage()])->withInput();
        }

        return redirect()->route('modules.show', ['module' => $module])->with('success', 'Record saved successfully.');
    }

    public function update(Request $request, string $module, int $id): RedirectResponse
    {
        abort_unless(in_array($module, ['farmers', 'locations', 'products', 'collections'], true), 404);

        match ($module) {
            'farmers' => Farmer::query()->findOrFail($id)->update($request->validate([
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:40', Rule::unique('farmers', 'phone')->ignore($id)],
                'country' => ['required', 'string', 'max:120'],
                'province' => ['required', 'string', 'max:120'],
                'district' => ['required', 'string', 'max:120'],
                'sector' => ['required', 'string', 'max:120'],
                'cell' => ['required', 'string', 'max:120'],
                'village' => ['required', 'string', 'max:120'],
            ])),
            'locations' => Location::query()->findOrFail($id)->update($request->validate([
                'name' => ['required', 'string', 'max:255'],
                'code' => ['required', 'string', 'max:80', Rule::unique('locations', 'code')->ignore($id)],
                'country' => ['required', 'string', 'max:120'],
                'province' => ['required', 'string', 'max:120'],
                'district' => ['required', 'string', 'max:120'],
                'sector' => ['required', 'string', 'max:120'],
                'cell' => ['required', 'string', 'max:120'],
                'village' => ['required', 'string', 'max:120'],
                'is_active' => ['nullable', 'boolean'],
            ])),
            'products' => Product::query()->findOrFail($id)->update($request->validate([
                'name' => ['required', 'string', 'max:255', Rule::unique('products', 'name')->ignore($id)],
                'sku' => ['required', 'string', 'max:120', Rule::unique('products', 'sku')->ignore($id)],
                'is_active' => ['nullable', 'boolean'],
            ])),
            'collections' => MaizeCollection::query()->findOrFail($id)->update($request->validate([
                'farmer_id' => ['required', 'integer', 'exists:farmers,id'],
                'location_id' => ['required', 'integer', 'exists:locations,id'],
                'collection_date' => ['required', 'date'],
                'quantity_collected' => ['required', 'numeric', 'gt:0'],
                'quantity_rejected' => ['nullable', 'numeric', 'gte:0'],
                'rejection_reason' => ['nullable', 'string'],
                'price_per_kg' => ['required', 'numeric', 'gt:0'],
            ])),
        };

        return redirect()->route('modules.show', ['module' => $module])->with('success', 'Record updated.');
    }

    public function destroy(string $module, int $id): RedirectResponse
    {
        abort_unless(in_array($module, ['farmers', 'locations', 'products', 'collections'], true), 404);

        match ($module) {
            'farmers' => Farmer::query()->findOrFail($id)->delete(),
            'locations' => Location::query()->findOrFail($id)->delete(),
            'products' => Product::query()->findOrFail($id)->delete(),
            'collections' => MaizeCollection::query()->findOrFail($id)->delete(),
        };

        return redirect()->route('modules.show', ['module' => $module])->with('success', 'Record deleted.');
    }

    private function createProductionBatch(Request $request): void
    {
        $data = $request->validate([
            'batch_number' => ['required', 'string', 'max:100', 'unique:production_batches,batch_number'],
            'location_id' => ['required', 'integer', 'exists:locations,id'],
            'maize_used' => ['required', 'numeric', 'gt:0'],
            'quantity_produced' => ['required', 'numeric', 'gt:0'],
            'wastage_quantity' => ['required', 'numeric', 'gte:0'],
            'quality_percentage' => ['required', 'numeric', 'between:0,100'],
            'production_date' => ['required', 'date'],
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'product_package_id' => ['required', 'integer', 'exists:product_packages,id'],
            'wastage_reason' => ['nullable', 'string'],
        ]);

        $this->productionService->createBatch([
            ...Arr::except($data, ['product_id', 'product_package_id']),
            'outputs' => [[
                'product_id' => (int) $data['product_id'],
                'product_package_id' => (int) $data['product_package_id'],
                'quantity' => (float) $data['quantity_produced'],
            ]],
        ]);
    }

    private function createSale(Request $request): void
    {
        $data = $request->validate([
            'invoice_number' => ['required', 'string', 'max:120', 'unique:sales,invoice_number'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:80'],
            'customer_address' => ['nullable', 'string'],
            'location_id' => ['required', 'integer', 'exists:locations,id'],
            'payment_method' => ['required', Rule::in(['cash', 'mobile_money', 'bank_transfer', 'credit'])],
            'delivery_status' => ['required', Rule::in(['pending', 'in_transit', 'delivered'])],
            'sale_date' => ['required', 'date'],
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'product_package_id' => ['required', 'integer', 'exists:product_packages,id'],
            'production_batch_id' => ['nullable', 'integer', 'exists:production_batches,id'],
            'quantity' => ['required', 'numeric', 'gt:0'],
            'price' => ['required', 'numeric', 'gt:0'],
        ]);

        $this->salesService->createSale([
            ...Arr::except($data, ['product_id', 'product_package_id', 'production_batch_id', 'quantity', 'price']),
            'items' => [[
                'product_id' => (int) $data['product_id'],
                'product_package_id' => (int) $data['product_package_id'],
                'production_batch_id' => $data['production_batch_id'] ? (int) $data['production_batch_id'] : null,
                'quantity' => (float) $data['quantity'],
                'price' => (float) $data['price'],
            ]],
        ]);
    }

    private function recordsForModule(string $module): mixed
    {
        return match ($module) {
            'farmers' => Farmer::query()->latest()->paginate(15),
            'locations' => Location::query()->latest()->paginate(15),
            'collections' => MaizeCollection::query()->with(['farmer', 'location'])->latest('collection_date')->paginate(15),
'raw-inventory' => RawInventoryMovement::query()->with(['location', 'collection', 'productionBatch'])->latest('movement_date')->paginate(20),
        'production' => ProductionBatch::query()
            ->with(['location', 'outputs.product', 'outputs.package', 'expenses', 'wastage'])
            ->latest('production_date')
            ->paginate(15),
            'products' => Product::query()->latest()->paginate(15),
            'finished-inventory' => $this->finishedInventoryStock(),
            'sales' => Sale::query()->with('items')->latest('sale_date')->paginate(15),
            'returns' => SaleReturn::query()->with(['sale', 'saleItem'])->latest('return_date')->paginate(15),
            'expenses' => BatchExpense::query()->with('batch')->latest()->paginate(20),
            'payments' => Payment::query()->with('sale')->latest('payment_date')->paginate(20),
            default => collect(),
        };
    }

    private function finishedInventoryStock(): mixed
    {
        $stocks = FinishedInventoryMovement::query()
            ->selectRaw('
                product_id,
                location_id,
                SUM(CASE WHEN type = ? THEN quantity ELSE 0 END) - SUM(CASE WHEN type = ? THEN quantity ELSE 0 END) as available_stock,
                MAX(movement_date) as production_date,
                MAX(expiry_date) as expiry_date
            ', [FinishedInventoryMovement::TYPE_IN, FinishedInventoryMovement::TYPE_OUT])
            ->groupBy('product_id', 'location_id')
            ->havingRaw('SUM(CASE WHEN type = ? THEN quantity ELSE 0 END) - SUM(CASE WHEN type = ? THEN quantity ELSE 0 END) > 0', [FinishedInventoryMovement::TYPE_IN, FinishedInventoryMovement::TYPE_OUT])
            ->with(['product', 'location'])
            ->orderByDesc('production_date')
            ->paginate(20);

        $stocks->getCollection()->transform(function ($item) {
            $item->id = "{$item->product_id}-{$item->location_id}";
            $item->stock = $item->available_stock;
            $item->quality = optional($item->product)->quality_percentage ?? '-';
            $item->unit_cost = optional($item->product)->cost_price ?? 0;
            $item->suggested_price = optional($item->product)->selling_price ?? 0;
            $item->total_value = ($item->unit_cost ?? 0) * (float) $item->stock;
            $item->production_date = $item->production_date ? \Carbon\Carbon::parse($item->production_date) : null;
            $item->expiry_date = $item->expiry_date ? \Carbon\Carbon::parse($item->expiry_date) : null;
            return $item;
        });

        return $stocks;
    }

    private function lookupData(): array
    {
        return [
            'farmers' => Farmer::query()->orderBy('name')->get(['id', 'name']),
            'locations' => Location::query()->orderBy('name')->get(['id', 'name']),
            'products' => Product::query()->orderBy('name')->get(['id', 'name']),
            'packages' => ProductPackage::query()->orderBy('name')->get(['id', 'name', 'product_id']),
            'batches' => ProductionBatch::query()->orderByDesc('production_date')->get(['id', 'batch_number', 'location_id']),
            'sales' => Sale::query()->orderByDesc('sale_date')->get(['id', 'invoice_number']),
            'sale_items' => SaleItem::query()->orderByDesc('id')->get(['id', 'sale_id', 'product_id', 'quantity']),
            'today' => Carbon::today()->toDateString(),
        ];
    }

    private function dashboardData(string $activeModule): array
    {
        $counts = DB::select("
            SELECT
                (SELECT COUNT(*) FROM farmers) as farmers,
                (SELECT COUNT(*) FROM locations) as locations,
                (SELECT COUNT(*) FROM maize_collections) as collections,
                (SELECT COUNT(*) FROM products) as products,
                (SELECT COUNT(*) FROM production_batches) as production_batches,
                (SELECT COUNT(*) FROM sales) as sales
        ");
        $stats = (array) $counts[0];

        $menuItems = ImsMenu::moduleNav();

        return [$stats, $menuItems];
    }

    private function allowedModules(): array
    {
        return [
            'farmers',
            'locations',
            'collections',
            'raw-inventory',
            'production',
            'products',
            'finished-inventory',
            'sales',
            'returns',
            'expenses',
            'payments',
        ];
    }
}
