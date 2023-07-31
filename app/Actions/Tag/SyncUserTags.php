<?php

namespace App\Actions\Tag;

use App\Models\User;

class SyncUserTags {
    public function run(User $user, array $ids) {
        $user->tags()->sync($ids);
    }
}