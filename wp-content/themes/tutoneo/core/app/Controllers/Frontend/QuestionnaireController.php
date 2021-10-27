<?php

namespace App\Controllers\Frontend;

use App\Config\Config;
use App\Controllers\Controller;
use App\Models\ParentBookingForm;
use App\Models\StudentQuestionnaireForm;

class QuestionnaireController extends Controller
{
    public function __construct()
    {
        add_action('gform_post_submission_' . StudentQuestionnaireForm::ID, [$this, 'submit'], 10, 2);
        add_action('gform_post_submission_' . ParentBookingForm::ID, [$this, 'submit'], 10, 2);
        add_shortcode(Config::APP_PREFIX . 'student_questionnaire', [$this, 'get_student_questionnaire']);
        add_shortcode(Config::APP_PREFIX . 'parent_questionnaire', [$this, 'get_parent_questionnaire']);
    }

    public function get_student_questionnaire()
    {
        $this->view(Config::PUBLIC_VIEWS_DIR . '/student-questionnaire');
    }

    public function get_parent_questionnaire()
    {
        $this->view(Config::PUBLIC_VIEWS_DIR . '/parent-questionnaire');
    }

    public function submit($entry, $form)
    {
        $_SESSION['questionnaire_response'] = $entry;
    }
}