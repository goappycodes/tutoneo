<?php

use App\Controllers\Frontend\TeacherLessonCalendarController;

?>
<div class="modal fade show" id="lesson-reschedule-modal" tabindex="-1" aria-labelledby="lessonRescheduleModal" aria-modal="true" role="dialog" style="padding-left: 17px;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <!-- Close -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

                <!-- Heading -->
                <h2 class="font-weight-bold text-center mb-1">
                    <?php echo __('Reschedule Lesson') ?>
                </h2>

                <!-- Form -->
                <form class="ajax-form" id="lesson-reschedule-form">
                    <input type="hidden" name="action" value="<?php echo TeacherLessonCalendarController::UPDATE_LESSON_ACTION ?>">
                    <input type="hidden" name="reference_no">
                    <div class="row">
                        <div class="col-12">
                            <label for="start_time"><?php echo __('Date/Time') ?></label>
                            <input type="text" name="start_time" id="start_time" class="form-control custom-datetimepicker" placeholder="Choose new date/time">
                        </div>
                        <div class="col-12">
                            <button class="btn btn-block btn-success mt-3 lift">
                                <?php echo __('Reschedule') ?>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>