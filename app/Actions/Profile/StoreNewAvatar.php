<?php

namespace App\Actions\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoreNewAvatar {
    public function run($newAvatar) {
        $currentAvatar = Auth::user()->profile->avatar;
        if ($currentAvatar) {
            $this->deleteCurrentAvatar($currentAvatar);
        }
        return Storage::disk('avatars')->put(Auth::id(), $newAvatar);
    }

    private function deleteCurrentAvatar($currentAvatar) {
        Storage::disk('avatars')->delete($currentAvatar);
    }
}