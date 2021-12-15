<?php

namespace App\Config;

class Settings
{
    public static function teacher_hourly_rate()
    {
        return floatval(get_field('teacher_hourly_rate', 'option'));  
    }

    public static function new_teacher_hourly_rate($teacher_post_id , $level){
        
        $level = get_field('level' , $teacher_post_id);
        $x =  get_field('teacher_hourly_rates', 'option');
        // return $x['FR College'];
        foreach($x as $y){
            if( $y['level'] == $level ){
                return $y['hourly_rate'];
            }
        }
        // return false;
    }   

    public static function student_hourly_rate()
    {
        return floatval(get_field('student_hourly_rate', 'option'));
    }

    public static function get_default_lesson_duration()
    {
        return 1;
    }

    public static function lesson_completed_color()
    {
        return '#41d837';
    }

    public static function lesson_active_color()
    {
        return '#3769d8';
    }

    public static function lesson_pending_color(){
        return '#b4df9e';
    }

    public static function get_student_male_image()
    {
        return get_field('student_male', 'option');
    }

    public static function get_student_female_image()
    {
        return get_field('student_female', 'option');
    }

    public static function get_teacher_male_image()
    {
        return get_field('teacher_male', 'option');
    }

    public static function get_teacher_female_image()
    {
        return get_field('teacher_female', 'option');
    }

}