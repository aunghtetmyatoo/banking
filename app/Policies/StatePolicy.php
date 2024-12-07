<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\State;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view_state');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, State $state): bool
    {
        return $admin->can('view_state');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('create_state');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, State $state): bool
    {
        return $admin->can('update_state');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, State $state): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, State $state): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, State $state): bool
    {
        return false;
    }
}
