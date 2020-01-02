<?php

namespace App\Listeners;

use App\Events\UserCreatedEvent;

class AssignDefaultRoleToNewUserListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param UserCreatedEvent $event
     *
     * @return void
     */
    public function handle(UserCreatedEvent $event)
    {
        $event->user()->assignRole(config('authflow.users.default_role'));
    }
}
