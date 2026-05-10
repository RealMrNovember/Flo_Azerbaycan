<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

final class RbacSeeder extends Seeder
{
    public const ROLE_SUPER_ADMIN = 'Super Admin';
    public const ROLE_STORE_MANAGER = 'Store Manager';
    public const ROLE_WAREHOUSE_STAFF = 'Warehouse Staff';

    public function run(): void
    {
        Role::findOrCreate(self::ROLE_SUPER_ADMIN, 'web');
        Role::findOrCreate(self::ROLE_STORE_MANAGER, 'web');
        Role::findOrCreate(self::ROLE_WAREHOUSE_STAFF, 'web');
    }
}

