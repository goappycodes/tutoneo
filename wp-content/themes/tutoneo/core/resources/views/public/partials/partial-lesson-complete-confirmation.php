<?php

use App\Controllers\Frontend\TeacherLessonCalendarController;

?>
<div class="modal fade show" id="lesson-complete-confirmation" tabindex="-1" aria-labelledby="completeConfirmation" aria-modal="true" role="dialog" style="padding-left: 17px;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <!-- Close -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

                <!-- Heading -->
                <h2 class="font-weight-bold text-center mb-1">
                    <?php echo __('Lesson Complete Confirmation') ?>
                </h2>

                <!-- Text -->
                <p class="font-size-lg text-center text-muted mb-6 mb-md-8">
                    <?php echo __('Do you really want to mark this lesson as completed?') ?>
                </p>

                <!-- Form -->
                <form class="ajax-form" id="lesson-complete-form">
                    <input type="hidden" name="action" value="<?php echo TeacherLessonCalendarController::COMPLETE_LESSON_ACTION ?>">
                    <input type="hidden" name="reference_no">
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-block btn-success mt-3 lift">
                                <?php echo __('Complete Lesson') ?>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>