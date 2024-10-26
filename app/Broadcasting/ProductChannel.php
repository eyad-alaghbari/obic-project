<?php

namespace App\Broadcasting;

use App\Models\User;

class ProductChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user): array|bool
    {
        if ($user instanceof \App\Models\Admin || $user instanceof \App\Models\Customer) {
            return true;
        }
        throw new \Exception('You do not have permission to join this channel.', 403);
        
    }
}
