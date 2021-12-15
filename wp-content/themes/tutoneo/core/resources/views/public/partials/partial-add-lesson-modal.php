<?php 
use App\Controllers\Frontend\TeacherLessonCalendarController;
use App\Controllers\Frontend\StudentLessonCalendarController;
use App\Models\User;
use App\Services\Auth;

?>
<div class="modal fade show" id="add-lesson-modal" tabindex="-1" aria-labelledby="addLesson" aria-modal="true" role="dialog" style="padding-left: 17px;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <!-- Close -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

                <!-- Heading -->
                <h2 class="font-weight-bold text-center mb-1" id="add-lesson-title">
                    <?php echo __('Add a lesson') ?>
                </h2>

                <!-- Text -->
                <p class="font-size-lg text-center text-muted mb-6 mb-md-8">
                    <?php echo __('Select Booking and date/time') ?>
                </p>

                <!-- Form -->
                <form class="ajax-form" id="add-lesson-form">
                    <?php if(Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE)) : ?>
                        <input type="hidden" name="action" value="<?php echo StudentLessonCalendarController::ADD_LESSON_ACTION ?>">
                    <?php else : ?>
                        <input type="hidden" name="action" value="<?php echo TeacherLessonCalendarController::ADD_LESSON_ACTION ?>">
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-12 form-group">
                            <div class="form-label-group">
                                <select name="reference_no" id="reference_no" class="form-control form-control-flush">
                                    <option value=""><?php echo __('Select booking') ?></option>
                                </select>
                                <label for="reference_no"><?php echo __('Booking') ?></label>
                            </div>
                        </div>

                        <div class="col-12 form-group">
                            <label for="start_time"><?php echo __('Start Time') ?></label>
                            <input type="text" name="start_time" id="start_time" class="form-control custom-datetimepicker" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">

                            <!-- Submit -->
                            <button class="btn btn-block btn-primary mt-3 lift">
                                <?php echo __('Add Lesson') ?>
                            </button>

                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>