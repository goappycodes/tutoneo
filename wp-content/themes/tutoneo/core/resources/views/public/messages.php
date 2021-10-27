<?php 
use App\Controllers\Frontend\MessagesController;

$messages_controller = MessagesController::init();

include_once('partials/partial-account-header.php'); 
?>

<main class="pb-8 pb-md-11 mt-md-n6">
    <div class="container-md">
        <div class="row">
            <?php include_once('partials/partial-account-sidebar.php') ?>
            <div class="col-12 col-md-9">

                <!-- Card -->
                <div class="card card-bleed shadow-light-lg mb-6">
                    <div class="card-header">

                        <!-- Heading -->
                        <h4 class="mb-0 font-weight-bold">
                            <?php echo __('Messages') ?>
                        </h4>

                    </div>
                    <div class="card-body">
                        <?php echo do_shortcode('[front-end-pm]'); ?>
                    </div>
                </div>

            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</main>