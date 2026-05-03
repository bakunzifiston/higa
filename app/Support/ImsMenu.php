<?php

namespace App\Support;

use App\Models\User;

class ImsMenu
{
    /** @var array<string, list<string>|null> null = unrestricted (never used directly; admin handled separately) */
    private const ROLE_MODULES = [
        'admin' => null,
        'collection-officer' => ['farmers', 'locations', 'collections', 'raw-inventory'],
        'production-manager' => ['locations', 'raw-inventory', 'production', 'products', 'finished-inventory', 'expenses'],
        'sales-team' => ['sales', 'returns', 'payments', 'expenses'],
    ];

    /** @return list<array{slug: string, label: string, endpoint: string, icon: string}> */
    private static function menuTemplate(): array
    {
        return [
            ['slug' => 'dashboard', 'label' => 'Dashboard', 'href' => route('dashboard'), 'icon' => 'fa-solid fa-chart-line'],
            ['slug' => 'farmers', 'label' => 'Farmers', 'href' => route('modules.show', ['module' => 'farmers']), 'icon' => 'fa-solid fa-tractor'],
            ['slug' => 'locations', 'label' => 'Warehouses', 'href' => route('modules.show', ['module' => 'locations']), 'icon' => 'fa-solid fa-warehouse'],
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
    }

    private static function toNavItems(array $items): array
    {
        return collect($items)
            ->map(fn (array $item) => [
                'slug' => $item['slug'],
                'label' => $item['label'],
                'endpoint' => $item['href'],
                'icon' => $item['icon'],
            ])
            ->values()
            ->all();
    }

    /**
     * @return list<array{slug: string, label: string, endpoint: string, icon: string}>
     */
    public static function moduleNav(?User $user = null): array
    {
        $all = self::menuTemplate();

        if (! $user) {
            return self::toNavItems($all);
        }

        if (! $user->role) {
            return self::toNavItems(array_values(array_filter(
                $all,
                fn (array $item) => in_array($item['slug'], ['dashboard', 'profile'], true)
            )));
        }

        if ($user->role->slug === 'admin') {
            return self::toNavItems($all);
        }

        $roleSlug = $user->role->slug;

        if (! array_key_exists($roleSlug, self::ROLE_MODULES)) {
            return self::toNavItems(array_values(array_filter(
                $all,
                fn (array $item) => in_array($item['slug'], ['dashboard', 'profile'], true)
            )));
        }

        $allowed = self::ROLE_MODULES[$roleSlug];
        if ($allowed === null) {
            return self::toNavItems($all);
        }

        $filtered = array_filter(
            $all,
            fn (array $item) => in_array($item['slug'], $allowed, true)
                || in_array($item['slug'], ['dashboard', 'profile'], true)
        );

        return self::toNavItems(array_values($filtered));
    }
}
