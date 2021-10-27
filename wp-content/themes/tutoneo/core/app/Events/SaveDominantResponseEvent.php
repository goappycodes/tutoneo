<?php

namespace App\Events;

use App\Models\User;
use App\Notifications\User\DominantMemorySubmissionNotification;

class SaveDominantResponseEvent extends Event 
{
    private $user;

    public function __construct(User $user) 
    {
        $this->user = $user;
    }

    public function fire()
    {
        try {
            (new DominantMemorySubmissionNotification($this->user))->send();
        } catch (\Exception $e) {
            send_error_email($e);
        }
    }
}