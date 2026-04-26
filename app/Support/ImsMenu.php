<?php

namespace App\Support;

class ImsMenu
{
    /**
     * @return list<array{slug: string, label: string, href: string}>
     */
    public static function moduleNav(): array
    {
        return [
            ['slug' => 'dashboard', 'label' => 'Dashboard', 'href' => route('dashboard')],
            ['slug' => 'farmers', 'label' => 'Farmers', 'href' => route('modules.show', ['module' => 'farmers'])],
            ['slug' => 'locations', 'label' => 'Locations', 'href' => route('modules.show', ['module' => 'locations'])],
            ['slug' => 'collections', 'label' => 'Collections', 'href' => route('modules.show', ['module' => 'collections'])],
            ['slug' => 'raw-inventory', 'label' => 'Raw Inventory', 'href' => route('modules.show', ['module' => 'raw-inventory'])],
            ['slug' => 'production', 'label' => 'Production', 'href' => route('modules.show', ['module' => 'production'])],
            ['slug' => 'products', 'label' => 'Products', 'href' => route('modules.show', ['module' => 'products'])],
            ['slug' => 'finished-inventory', 'label' => 'Finished Inventory', 'href' => route('modules.show', ['module' => 'finished-inventory'])],
            ['slug' => 'sales', 'label' => 'Sales', 'href' => route('modules.show', ['module' => 'sales'])],
            ['slug' => 'returns', 'label' => 'Returns', 'href' => route('modules.show', ['module' => 'returns'])],
            ['slug' => 'expenses', 'label' => 'Expenses', 'href' => route('modules.show', ['module' => 'expenses'])],
            ['slug' => 'payments', 'label' => 'Payments', 'href' => route('modules.show', ['module' => 'payments'])],
            ['slug' => 'profile', 'label' => 'Profile', 'href' => route('profile.edit')],
        ];
    }
}
