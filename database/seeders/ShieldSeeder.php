<?php

namespace Database\Seeders;

use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Notifications\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $permissions = File::get(base_path('database/seeders/data/shield.json'));
        static::makeRolesWithPermissions($permissions);
    }

    protected static function makeRolesWithPermissions(string $permissions): void
    {
        if (! blank($permissions = json_decode($permissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $rolePlusPermission) {

                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                $syncPermissions = new Collection;

                foreach ($rolePlusPermission['permissions'] as $groupName => $groupPermissions) {
                    if (count($groupPermissions)) {
                        $permissionModels = collect($groupPermissions)
                            ->map(function ($permission) use ($permissionModel, $rolePlusPermission) {
                                return $permissionModel::firstOrCreate([
                                    'name' => $permission,
                                    'guard_name' => $rolePlusPermission['guard_name'],
                                ]);
                            })
                            ->all();

                        $syncPermissions->push($permissionModels);
                    }
                }

                $role->syncPermissions($syncPermissions);
            }
        }
    }
}
