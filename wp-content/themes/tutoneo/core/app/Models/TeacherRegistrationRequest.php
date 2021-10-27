<?php

namespace App\Models;

class TeacherRegistrationRequest extends Post 
{
    const POST_TYPE          = 'teacher-registration';
    const FIRST_NAME         = 'first_name';
    const LAST_NAME          = 'last_name';
    const EMAIL              = 'email';
    const GENDER             = 'gender';
    const OCC_TYPE           = 'occ_type';
    const STU_STUDIES        = 'student_studies';
    const EMP_FIELD          = 'employment_field';
    const STU_STUDY_YEAR     = 'student_study_year';
    const EMP_POSITION       = 'employment_position';
    const EMP_DIPLOMA        = 'employment_diploma';
    const SUB_TO_TEACH       = 'subjects_to_teach';
    const JOIN_REASON        = 'joinning_reason';
    const ADVICE_METHODOLOGY = 'advice_methodology';
    const ADVICE_ORIENTATION = 'advice_orientation';
    const SUPPORT_PRO_LIFE   = 'support_professional_life';
    const HOURS_AVBL         = 'hours_available';
    const TEACH_PHYSICALLY   = 'teach_physically';
    const TEACH_ONLINE       = 'teach_online';
    const ATT_ID_CARD        = 'att_id_card';
    const ATT_UNIVERSITY     = 'att_university_regn';
    const ATT_DIPLOMA        = 'att_diploma';
    const ATT_CRIMINAL_REC   = 'att_criminal_record';
    const ATT_CV             = 'att_cv';
    const STATUS             = 'status';
    const STATUS_PENDING     = 'Pending';
    const STATUS_ACCEPTED    = 'Accepted';
    const STATUS_DECLINED    = 'Declined';

    public function get_first_name()
    {
        return $this->get_meta(self::FIRST_NAME);
    }

    public function get_last_name()
    {
        return $this->get_meta(self::LAST_NAME);
    }

    public function get_full_name()
    {
        $first_name = $this->get_first_name();
        $last_name = $this->get_last_name();
        return $first_name . ' ' . $last_name;
    }

    public function get_gender()
    {
        return $this->get_meta(self::GENDER);
    }

    public function get_email()
    {
        return $this->get_meta(self::EMAIL);
    }

    public function get_occupation()
    {
        return $this->get_meta(self::OCC_TYPE);
    }

    public function get_subjects()
    {
        return $this->get_meta(self::SUB_TO_TEACH);
    }

    public function get_id_card_path()
    {
        return $this->get_meta(self::ATT_ID_CARD);
    }

    public function get_cv_path()
    {
        return $this->get_meta(self::ATT_CV);
    }

    public function get_status()
    {
        return $this->get_meta(self::STATUS);
    }

    public function set_status($status)
    {
        return $this->set_meta(self::STATUS, $status);
    }
}