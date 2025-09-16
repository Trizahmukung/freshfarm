<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderItemPolicy
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

        return in_array("View order item", $user->simplePermissions);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, OrderItem $orderItem)
    {
        //
        return in_array("View order item", $user->simplePermissions);
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
        return in_array("Create order item", $user->simplePermissions);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, OrderItem $orderItem)
    {
        //
        return in_array("Edit order item", $user->simplePermissions);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, OrderItem $orderItem)
    {
        //
        return in_array("Delete order item", $user->simplePermissions);

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, OrderItem $orderItem)
    {
        //
        return in_array("Delete order item", $user->simplePermissions);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, OrderItem $orderItem)
    {
        //
        return in_array("Delete order item", $user->simplePermissions);
    }
}
