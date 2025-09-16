<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Delivery;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryPolicy
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

        return in_array("View delivery", $user->simplePermissions);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Delivery $delivery)
    {
        //
        return in_array("View delivery", $user->simplePermissions);
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
        return in_array("Create delivery", $user->simplePermissions);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Delivery $delivery)
    {
        //
        return in_array("Edit delivery", $user->simplePermissions);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Delivery $delivery)
    {
        //
        return in_array("Delete delivery", $user->simplePermissions);

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Delivery $delivery)
    {
        //
        return in_array("Delete delivery", $user->simplePermissions);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Delivery $delivery)
    {
        //
        return in_array("Delete delivery", $user->simplePermissions);
    }
}
