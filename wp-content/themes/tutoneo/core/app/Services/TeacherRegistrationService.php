<?php

namespace App\Services;

use App\Models\TeacherRegistrationForm;
use App\Models\TeacherRegistrationRequest;

class TeacherRegistrationService
{
    public static function prepare_request_data($entry, $form)
    {
        return [
            'post_title' => 'Request from ' . rgar($entry, TeacherRegistrationForm::FIRST_NAME),
            'post_type' => TeacherRegistrationRequest::POST_TYPE,
            'post_status' => 'publish'
        ];
    }

    public static function prepare_request_meta_data($entry, $form)
    {
        return [
            TeacherRegistrationRequest::FIRST_NAME         => rgar($entry, TeacherRegistrationForm::FIRST_NAME),
            TeacherRegistrationRequest::LAST_NAME          => rgar($entry, TeacherRegistrationForm::LAST_NAME),
            TeacherRegistrationRequest::EMAIL              => rgar($entry, TeacherRegistrationForm::EMAIL),
            TeacherRegistrationRequest::GENDER             => rgar($entry, TeacherRegistrationForm::GENDER),
            TeacherRegistrationRequest::OCC_TYPE           => self::get_occ_type(rgar($entry, TeacherRegistrationForm::OCC_TYPE)),
            TeacherRegistrationRequest::STU_STUDIES        => rgar($entry, TeacherRegistrationForm::STU_STUDIES),
            TeacherRegistrationRequest::EMP_FIELD          => rgar($entry, TeacherRegistrationForm::EMP_FIELD),
            TeacherRegistrationRequest::STU_STUDY_YEAR     => rgar($entry, TeacherRegistrationForm::STU_STUDY_YEAR),
            TeacherRegistrationRequest::EMP_POSITION       => rgar($entry, TeacherRegistrationForm::EMP_POSITION),
            TeacherRegistrationRequest::EMP_DIPLOMA        => rgar($entry, TeacherRegistrationForm::EMP_DIPLOMA),
            TeacherRegistrationRequest::SUB_TO_TEACH       => rgar($entry, TeacherRegistrationForm::SUB_TO_TEACH),
            TeacherRegistrationRequest::JOIN_REASON        => rgar($entry, TeacherRegistrationForm::JOIN_REASON),
            TeacherRegistrationRequest::ADVICE_METHODOLOGY => rgar($entry, TeacherRegistrationForm::ADVICE_METHODOLOGY) == 'Yes' ? 1 : 0,
            TeacherRegistrationRequest::ADVICE_ORIENTATION => rgar($entry, TeacherRegistrationForm::ADVICE_ORIENTATION) == 'Yes' ? 1 : 0,
            TeacherRegistrationRequest::SUPPORT_PRO_LIFE   => rgar($entry, TeacherRegistrationForm::SUPPORT_PRO_LIFE) == 'Yes' ? 1 : 0,
            TeacherRegistrationRequest::HOURS_AVBL         => rgar($entry, TeacherRegistrationForm::HOURS_AVBL) == 'Yes' ? 1 : 0,
            TeacherRegistrationRequest::TEACH_PHYSICALLY   => rgar($entry, TeacherRegistrationForm::TEACH_PHYSICALLY) == 'Yes' ? 1 : 0,
            TeacherRegistrationRequest::TEACH_ONLINE       => rgar($entry, TeacherRegistrationForm::TEACH_ONLINE) == 'Yes' ? 1 : 0,
            TeacherRegistrationRequest::ATT_ID_CARD        => rgar($entry, TeacherRegistrationForm::ATT_ID_CARD),
            TeacherRegistrationRequest::ATT_UNIVERSITY     => rgar($entry, TeacherRegistrationForm::ATT_UNIVERSITY),
            TeacherRegistrationRequest::ATT_DIPLOMA        => rgar($entry, TeacherRegistrationForm::ATT_DIPLOMA),
            TeacherRegistrationRequest::ATT_CRIMINAL_REC   => rgar($entry, TeacherRegistrationForm::ATT_CRIMINAL_REC),
            TeacherRegistrationRequest::ATT_CV             => rgar($entry, TeacherRegistrationForm::ATT_CV),
            TeacherRegistrationRequest::STATUS             => TeacherRegistrationRequest::STATUS_PENDING,
        ];
    }

    public static function get_occ_type($entry_data)
    {
        if (stripos($entry_data, 'student') !== false) {
            return 'Student';
        } else {
            return 'Employee';
        }
    }
}