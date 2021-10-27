<?php

namespace App\Controllers\Frontend;

use App\Controllers\Controller;
use App\Services\GravityFormService;

class GravityFormModifierController extends Controller
{
    public function __construct()
    {
        add_filter( 'gform_field_content', [$this, 'modify_content'], 10, 5 );
    }

    public function modify_content( $content, $field, $value, $lead_id, $form_id ) 
    {
        $form_choice_images = get_field('form_choice_images');
        
        if (!$form_choice_images) {
            return $content;
        }

        foreach ($form_choice_images as $label_image) {
            $content = GravityFormService::append_image_if_label_exists($content, $field, $label_image);
        }

        return $content;
    }
}