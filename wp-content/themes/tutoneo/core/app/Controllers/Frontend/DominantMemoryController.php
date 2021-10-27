<?php

namespace App\Controllers\Frontend;

use App\Models\Page;
use App\Models\User;
use App\Config\Config;
use App\Controllers\Controller;
use App\Services\Auth;
use App\Models\DominantMemoryForm;
use App\Events\SaveDominantResponseEvent;

class DominantMemoryController extends Controller
{
    public function __construct()
    {
        register_page_scripts(Page::STUDENT_DOMINANT_MEMORY);
        add_shortcode(Config::APP_PREFIX . 'dominant_memory', [$this, 'get_dominant_memory']);
        add_action('gform_post_submission_' . DominantMemoryForm::ID, [$this, 'submit'], 10, 2);
    }

    public function get_dominant_memory()
    {
        if (!Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE)) {
            Auth::show_403();
        }

        if (Auth::check()) {
            $file = Auth::user()->has_dominant_response() ? '/dominant-memory-responses' : '/dominant-memory';
            $this->view(Config::PUBLIC_VIEWS_DIR . $file);
        }
    }

    public function submit($entry, $form)
    {
        $user = Auth::user();
        $user->set_dominant_memory_response($entry['id']);

        $event = new SaveDominantResponseEvent($user);
        $event->fire();
    }
}
