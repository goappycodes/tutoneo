<?php

namespace App\Services;

class GravityFormService
{
    public static function append_image_if_label_exists($content, $field, $label_image) 
    {
        $pos = self::get_position_of_label($content, $field, $label_image['label']);

        if ($pos !== false) {
            $image_url = $label_image['image'];
            $image = "<img src='{$image_url}' alt='image'>";
        } else {
            $image = '';
        }
        
        $content = substr($content, 0, $pos) . $image . substr($content, $pos);
        return $content;
    }

    public static function get_position_of_label($content, $field, $label) 
    {
        if (in_array($label, self::get_all_labels_of_a_field($field))) {
            return strrpos($content, $label);
        }

        return false;
    }

    public static function get_all_labels_of_a_field($field)
    {
        $labels[] = $field->label;
        $choices = $field->choices;
        
        if (is_array($choices) && count($choices)) {
            foreach ($choices as $choice) {
                $labels[] = $choice['text'];
            }
        }

        return $labels;
    }
}