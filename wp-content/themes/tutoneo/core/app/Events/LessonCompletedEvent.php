<?php

namespace App\Events;

use App\Models\Lesson;
use App\Models\TeacherLedger;
use App\Notifications\Lesson\LessonCompletedAdminNotification;
use App\Notifications\Lesson\LessonCompletedTeacherNotification;
use App\Notifications\Lesson\LessonCompletedUserNotification;

class LessonCompletedEvent extends Event
{
    private $lesson;

    public function __construct(Lesson $lesson)
    {
        $this->lesson = $lesson;
    }

    public function fire()
    {
        $this->lesson->mark_complete();
        $this->add_teacher_payment();

        try {
            (new LessonCompletedUserNotification($this->lesson))->send();
            (new LessonCompletedTeacherNotification($this->lesson))->send();
            (new LessonCompletedAdminNotification($this->lesson))->send();
        } catch (\Exception $e) {
            send_error_email($e);
        }
    }

    public function add_teacher_payment()
    {
        $ref = TeacherLedger::create_reference_no();

        $teacher_ledger = TeacherLedger::insert([
            'post_title' => "TeacherLedger #" . $ref,
            'post_type' => TeacherLedger::POST_TYPE,
            'post_status' => 'publish'
        ]);

        $teacher_ledger->update_meta_set([
            TeacherLedger::REFERENCE => $ref,
            TeacherLedger::TXN_TYPE  => TeacherLedger::TXN_EARNING,
            TeacherLedger::USER      => $this->lesson->teacher()->get_id(),
            TeacherLedger::BOOKING   => $this->lesson->booking()->get_id(), 
            TeacherLedger::LESSON    => $this->lesson->get_id(), 
            TeacherLedger::AMOUNT    => $this->lesson->teacher_amount(),
        ]);
    }
}
