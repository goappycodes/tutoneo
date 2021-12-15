<?php

use App\Services\Auth;
use App\Controllers\Frontend\TeacherLessonCalendarController;

?>
<div class="modal fade show" id="lesson-confirm-action-modal" tabindex="-1" aria-labelledby="lessonAction" aria-modal="true" role="dialog" style="padding-left: 17px;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <!-- Close -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

                <!-- Heading -->
                <h2 class="font-weight-bold text-center mb-1" id="add-lesson-title">
                    <?php echo __('Take a Action') ?>
                </h2>
                <div class="row">
                    <div class="form-group col-md-12 lesson-action-btn mt-5 text-center">
                        <form class="ajax-form" id="confirm-lesson-form" method="POST">
                            <?php if (Auth::user()->is_teacher()): ?>
                                <input type="hidden" name="action" value="<?php echo TeacherLessonCalendarController::CONFIRM_LESSON_ACTION ?>">
                                <button class="lesson-request-confirm btn btn-success mr-5"><?php echo __('Confirm') ?></a>
                            <?php endif; ?>

                            <button class="lesson-cancel-request btn btn-danger mr-5"><?php echo __('Cancel') ?></a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>