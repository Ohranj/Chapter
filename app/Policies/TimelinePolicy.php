<?php

namespace App\Policies;

use App\Models\Timeline;
use App\Models\User;

class TimelinePolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Timeline $timeline): bool
    {
        return $timeline->user_id == $user->id;
    }
}
