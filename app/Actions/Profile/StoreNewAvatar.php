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
        return Storage::disk('public')->put('avatars', $newAvatar);
    }

    private function deleteCurrentAvatar($currentAvatar) {
        Storage::disk('public')->delete($currentAvatar);
    }
}