<?php

namespace App\Support;

class ImsMenu
{
    /**
     * @return list<array{slug: string, label: string, href: string, icon: string}>
     */
    public static function moduleNav(): array
    {
        return [
            ['slug' => 'dashboard', 'label' => 'Dashboard', 'href' => route('dashboard'), 'icon' => 'fa-solid fa-chart-line'],
            ['slug' => 'farmers', 'label' => 'Farmers', 'href' => route('modules.show', ['module' => 'farmers']), 'icon' => 'fa-solid fa-tractor'],
            ['slug' => 'locations', 'label' => 'Locations', 'href' => route('modules.show', ['module' => 'locations']), 'icon' => 'fa-solid fa-location-dot'],
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
}

