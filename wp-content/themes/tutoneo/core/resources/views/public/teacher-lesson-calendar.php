<?php
include_once('partials/partial-account-header.php');
?>
<main class="pb-8 pb-md-11 mt-md-n6">
    <div class="container-md">
        <div class="row">
            <?php include_once('partials/partial-account-sidebar.php') ?>
            <div class="col-12">
                <div class="card card-bleed shadow-light-lg mb-6">
                    <div class="card-header d-flex justify-content-space-between">
                        <h4 class="mb-0 font-weight-bold">
                            <?php echo __('Lesson Calendar') ?>
                        </h4>
                        <div class="text-right">
                            <a href="#add-lesson-modal" data-toggle="modal" class="btn btn-xs btn-primary">
                                <?php echo __('Add Lesson') ?>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col">
                                <div id="teacher-lesson-calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</main>

<?php 
include_once('partials/partial-lesson-action-modal.php');
include_once('partials/partial-add-lesson-modal.php');
include_once('partials/partial-lesson-cancel-modal.php');
include_once('partials/partial-lesson-complete-confirmation.php');
include_once('partials/partial-lesson-reschedule-modal.php');
?>