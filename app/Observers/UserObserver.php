<?php

namespace App\Observers;

use App\Eloquent\Auth\User;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\Eloquent\Auth\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $user->assignRole(config('authflow.users.default_role'));
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\Eloquent\Auth\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\Eloquent\Auth\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "deleting" event.
     *
     * @param  \App\Eloquent\Auth\User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        // Revoke all permissions
        $user->syncPermissions();
        $user->syncRoles();
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\Eloquent\Auth\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\Eloquent\Auth\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
