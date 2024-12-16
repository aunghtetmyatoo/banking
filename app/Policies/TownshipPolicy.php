<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Township;

class TownshipPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view_township');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Township $township): bool
    {
        return $admin->can('view_township');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('create_township');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Township $township): bool
    {
        return $admin->can('update_township');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Township $township): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Township $township): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Township $township): bool
    {
        return false;
    }
}
