<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Farm;
use Illuminate\Auth\Access\HandlesAuthorization;

class FarmPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //

        return in_array("View farm", $user->simplePermissions);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Farm $farm)
    {
        //
        return in_array("View farm", $user->simplePermissions);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
        return in_array("Create farm", $user->simplePermissions);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Farm $farm)
    {
        //
        return in_array("Edit farm", $user->simplePermissions);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Farm $farm)
    {
        //
        return in_array("Delete farm", $user->simplePermissions);

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Farm $farm)
    {
        //
        return in_array("Delete farm", $user->simplePermissions);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Farm $farm)
    {
        //
        return in_array("Delete farm", $user->simplePermissions);
    }
}
