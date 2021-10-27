<?php

namespace App\Seeders;

use App\Models\EmailTemplate;

class EmailSeeder extends Seeder
{
    public static function seed()
    {
        self::truncate();

        $types = [
            EmailTemplate::REGISTRATION,
            EmailTemplate::BOOKING_ADMIN,
            EmailTemplate::BOOKING_USER,
            EmailTemplate::MATCH_FOUND_TEACHER,
            EmailTemplate::MATCH_FOUND_USER,
            EmailTemplate::MATCH_NOT_FOUND_USER,
            EmailTemplate::PAYMENT_REQUEST,
            EmailTemplate::PAYMENT_SUCCESS_USER,
            EmailTemplate::PAYMENT_SUCCESS_ADMIN,
            EmailTemplate::LESSON_CREATION_USER,
            EmailTemplate::LESSON_CREATION_TEACHER,
            EmailTemplate::LESSON_CREATION_ADMIN,
            EmailTemplate::LESSON_UPDATION_USER,
            EmailTemplate::LESSON_UPDATION_TEACHER,
            EmailTemplate::LESSON_UPDATION_ADMIN,
            EmailTemplate::LESSON_CANCELLATION_USER,
            EmailTemplate::LESSON_CANCELLATION_TEACHER,
            EmailTemplate::LESSON_CANCELLATION_ADMIN,
            EmailTemplate::LESSON_COMPLETION_USER,
            EmailTemplate::LESSON_COMPLETION_TEACHER,
            EmailTemplate::LESSON_COMPLETION_ADMIN,
            EmailTemplate::TEACHER_FEEDBACK,
        ];

        foreach ($types as $type) {
            $post_id = wp_insert_post([
                'post_title' => $type,
                'post_status' => 'publish',
                'post_type' => EmailTemplate::POST_TYPE
            ]);

            update_post_meta($post_id, EmailTemplate::TYPE, $type);
            update_post_meta($post_id, EmailTemplate::SUBJECT, 'Subject for: ' . $type);
            update_post_meta($post_id, EmailTemplate::BODY, 'Here goes body for: ' . $type);
        }
    }

    private static function truncate()
    {
        $allposts = get_posts(array('post_type' => EmailTemplate::POST_TYPE, 'numberposts' => -1));
        foreach ($allposts as $post) {
            wp_delete_post($post->ID, true);
        }
    }
}
