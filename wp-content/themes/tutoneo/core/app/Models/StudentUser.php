<?php

namespace App\Models;

class StudentUser extends User
{
    const FIRST_NAME        = 'first_name';
    const LAST_NAME         = 'last_name';
    const GENDER            = 'gender';
    const DATE_OF_BIRTH     = 'date_of_birth';
    const STREET_ADDRESS    = 'street_address';
    const STREET_ADDRESS_2  = 'address_line_2';
    const CITY              = 'city';
    const STATE_PROVINCE    = 'state_province';
    const ZIP_POSTAL        = 'zip_postal_code';
    const COUNTRY           = 'country';
    const PHONE             = 'phone_number';
    const SKYPE_ID          = 'skype_id';
    const ZOOM_ID           = 'zoom_id';
    const PARENT_FIRST_NAME = 'payer_first_name';
    const PARENT_LAST_NAME  = 'payer_last_name';
    const PARENT_EMAIL      = 'payer_email';
    const DOMINANT_RESPONSE = 'dominant_response_entry_id';
    const PROFILE_PIC_URL   = 'profile_pic_url';
    const PROFILE_PIC_FILE  = 'profile_pic_file';
}
