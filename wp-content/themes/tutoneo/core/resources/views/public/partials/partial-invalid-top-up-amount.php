<?php

use App\Controllers\Frontend\BookingsController;
use App\Services\Auth;
use App\Controllers\Frontend\TeacherLessonCalendarController;

?>
<div class="modal fade show" id="invalid_top_up_amount" tabindex="-1" aria-labelledby="invalidAmount" aria-modal="true" role="dialog" style="padding-left: 17px;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <!-- Close -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

                <!-- Heading -->
                <h2 class="font-weight-bold text-center mb-1" id="add-lesson-title">
                    <?php echo __('Please Enter a valid amount') ?>
                </h2>
            </div>
        </div>
    </div>
</div>