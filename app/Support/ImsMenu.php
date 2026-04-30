<?php

namespace App\Support;

use App\Models\User;

class ImsMenu
{
    // Module access by role slug
    private const ROLE_MODULES = [
        'admin' => null, // null = all modules
        'collection-officer' => ['farmers', 'locations', 'collections', 'raw-inventory'],
        'production-manager' => ['raw-inventory', 'production', 'products', 'finished-inventory', 'expenses'],
        'sales-team' => ['sales', 'returns', 'payments', 'expenses'],
    ];

    /**
     * @return list<array{slug: string, label: string, href: string, icon: string}>
     */
    public static function moduleNav(?User $user = null): array
    {
        $all = [
            ['slug' => 'dashboard', 'label' => 'Dashboard', 'href' => route('dashboard'), 'icon' => 'fa-solid fa-chart-line'],
            ['slug' => 'farmers', 'label' => 'Farmers', 'href' => route('modules.show', ['module' => 'farmers']), 'icon' => 'fa-solid fa-tractor'],
            ['slug' => 'warehouses', 'label' => 'Warehouses', 'href' => route('modules.show', ['module' => 'locations']), 'icon' => 'fa-solid fa-warehouse'],
            ['slug' => 'collections', 'label' => 'Collections', 'href' => route('modules.show', ['module' => 'collections']), 'icon' => 'fa-solid fa-wheat-awn'],
            ['slug' => 'raw-inventory', 'label' => 'Raw Inventory', 'href' => route('modules.show', ['module' => 'raw-inventory']), 'icon' => 'fa-solid fa-boxes-stacked'],
            ['slug' => 'production', 'label' => 'Production', 'href' => route('modules.show', ['module' => 'production']), 'icon' => 'fa-solid fa-industry'],
            ['slug' => 'products', 'label' => 'Products', 'href' => route('modules.show', ['module' => 'products']), 'icon' => 'fa-solid fa-tags'],
            ['slug' => 'finished-inventory', 'label' => 'Finished Inventory', 'href' => route('modules.show', ['module' => 'finished-inventory']), 'icon' => 'fa-solid fa-warehouse'],
            ['slug' => 'sales', 'label' => 'Sales', 'href' => route('modules.show', ['module' => 'sales']), 'icon' => 'fa-solid fa-cart-shopping'],
            ['slug' => 'returns', 'label' => 'Returns', 'href' => route('modules.show', ['module' => 'returns']), 'icon' => 'fa-solid fa-rotate-left'],
            ['slug' => 'expenses', 'label' => 'Expenses', 'href' => route('modules.show', ['module' => 'expenses']), 'icon' => 'fa-solid fa-money-bill-wave'],
            ['slug' => 'payments', 'label' => 'Payments', 'href' => route('modules.show', ['module' => 'payments']), 'icon' => 'fa-solid fa-hand-holding-dollar'],
            ['slug' => 'profile', 'label' => 'Profile', 'href' => route('profile.edit'), 'icon' => 'fa-solid fa-user'],
        ];

// If no user or admin, return all (use Collect for consistency)
        if (!$user || !$user->role) {
            return collect($all)->map(fn($item) => ['slug' => $item['slug'], 'label' => $item['label'], 'endpoint' => $item['href'], 'icon' => $item['icon']])->values()->toArray();
        }

        $roleSlug = $user->role->slug;
        if ($roleSlug === 'admin') {
            return collect($all)->map(fn($item) => ['slug' => $item['slug'], 'label' => $item['label'], 'endpoint' => $item['href'], 'icon' => $item['icon']])->values()->toArray();
        }

// Get allowed modules for role
        $allowed = self::ROLE_MODULES[$roleSlug] ?? [];
        if (!$allowed) {
            return collect($all)->map(fn($item) => ['slug' => $item['slug'], 'label' => $item['label'], 'endpoint' => $item['href'], 'icon' => $item['icon']])->values()->toArray();
        }

        // Map slugs to include warehouses (locations)
        $include = array_merge($allowed, ['warehouse' => 'locations']);

        return collect(array_filter($all, fn($item) => in_array($item['slug'], $allowed) || in_array($item['slug'], ['dashboard', 'profile'])))
            ->map(fn($item) => ['slug' => $item['slug'], 'label' => $item['label'], 'endpoint' => $item['href'], 'icon' => $item['icon']])
            ->values()
            ->toArray();
    }
}

