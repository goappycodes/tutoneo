<?php

use App\Services\Auth;

?>
<div class="modal fade show" id="lesson-action-modal" tabindex="-1" aria-labelledby="lessonAction" aria-modal="true" role="dialog" style="padding-left: 17px;">
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
                        <?php if (Auth::user()->is_teacher()): ?>
                        <button class="lesson-complete-request btn btn-success mr-5"><?php echo __('Complete') ?></a>
                        <button class="lesson-reschedule-request btn btn-info mr-5"><?php echo __('Reschedule') ?></a>
                        <?php else: ?>
                        <button class="lesson-postpone-request btn btn-info mr-5"><?php echo __('Postpone') ?></a>
                        <?php endif; ?>

                        <button class="lesson-cancel-request btn btn-danger mr-5"><?php echo __('Cancel') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>