<?php 
include_once('partials/partial-account-header.php');
?>

<main class="pb-8 pb-md-11 mt-md-n6">
    <div class="container-md">
        <div class="row">
            <?php include_once('partials/partial-account-sidebar.php') ?>
            <div class="col-12">
                <div class="card card-bleed shadow-light-lg mb-6">
                    <div class="card-header">
                        <h4 class="mb-0 font-weight-bold">
                            <?php echo __('Lesson Calendar') ?>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col">
                                <div id="student-lesson-calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</main>

<?php 
include('partials/partial-lesson-action-modal.php');
include('partials/partial-lesson-cancel-modal.php');
include('partials/partial-lesson-postpone-modal.php');
?>