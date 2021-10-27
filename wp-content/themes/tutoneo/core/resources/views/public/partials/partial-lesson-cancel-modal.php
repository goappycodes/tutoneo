<?php

use App\Controllers\Frontend\StudentLessonCalendarController;
use App\Controllers\Frontend\TeacherLessonCalendarController;
use App\Models\User;
use App\Services\Auth;

?>
<div class="modal fade show" id="lesson-cancel-confirmation" tabindex="-1" aria-labelledby="cancelConfirmation" aria-modal="true" role="dialog" style="padding-left: 17px;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <!-- Close -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

                <!-- Heading -->
                <h2 class="font-weight-bold text-center mb-1">
                    <?php echo __('Lesson Cancellation') ?>
                </h2>

                <!-- Text -->
                <p class="font-size-lg text-center text-muted mb-6 mb-md-8">
                    <?php echo __('Do you really want to cancel this lesson?') ?>
                </p>

                <!-- Form -->
                <form class="ajax-form" id="lesson-cancel-form">
                    <?php if (Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE)): ?>
                        <input type="hidden" name="action" value="<?php echo StudentLessonCalendarController::CANCEL_ACTION ?>">
                    <?php endif; ?>
                    <?php if (Auth::has_role(User::TEACHER_ROLE)): ?>
                        <input type="hidden" name="action" value="<?php echo TeacherLessonCalendarController::CANCEL_LESSON_ACTION ?>">
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-12">
                            <label for="reason"><?php echo __('Reason') ?></label>
                            <input type="text" name="reason" id="reason" class="form-control" placeholder="Enter Reason">
                            <input type="hidden" name="reference_no">
                        </div>
                        <div class="col-12">
                            <button class="btn btn-block btn-danger mt-3 lift">
                                <?php echo __('Cancel Lesson') ?>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>