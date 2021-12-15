<?php

use App\Controllers\Frontend\BookingsController;
use App\Services\Auth;
use App\Controllers\Frontend\TeacherLessonCalendarController;

?>
<div class="modal fade show" id="report-problem-action-modal" tabindex="-1" aria-labelledby="lessonAction" aria-modal="true" role="dialog" style="padding-left: 17px;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <!-- Close -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

                <!-- Heading -->
                <h2 class="font-weight-bold text-center mb-1" id="add-lesson-title">
                    <?php echo __('Take an Action') ?>
                </h2>
                <div class="row">
                    <div class="form-group col-md-12 lesson-action-btn mt-5 text-center">
                        <form class="ajax-form" id="report-problem-form" method="POST">
                                <input type="hidden" name="action" value="<?php echo BookingsController::REPORT_BOOKING_PROBELM ?>">
                                <input type="hidden" name="reference_no" value="">
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="problem" id="report_another_issue" value="Report another issue">
                                            <label class="form-check-label" for="report_another_issue">Report another issue</label>
                                            <input class="form-check-input" type="radio" name="problem" id="no_class" value="I don't have a class">
                                            <label class="form-check-label" for="no_class"> I don't have a class&nbsp;&nbsp;</label>
                                        </div>
                                        <div class="form-check">
                                            
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <!-- <button class="btn btn-block btn-success mt-3 lift" id="report_submit">
                                            <?php //echo __('Report') ?>
                                        </button> -->
                                        <input type="submit" value="Report">
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>