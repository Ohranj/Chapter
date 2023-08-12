<?php

namespace App\Actions\Timeline;

class DeleteEntry {
    public function run($timeline) {
        return $timeline->delete();
    }
}