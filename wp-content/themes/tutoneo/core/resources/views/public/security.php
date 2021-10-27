<?php

use App\Controllers\Frontend\SecurityController;

include_once('partials/partial-account-header.php');
?>

<!-- MAIN
    ================================================== -->
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
                            <?php echo __('Security') ?>
                        </h4>

                    </div>
                    <div class="card-body">
                        <form id="security-form" class="ajax-form">
                            <input type="hidden" name="action" value="<?php echo SecurityController::ACTION ?>">
                            <div class="row form-group">
                                <div class="col-md-12 form-group">
                                    <label for="current_password">Current Password</label>
                                    <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Current Password">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="new_password">New Password</label>
                                    <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Password Confirmation">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="gform_next_button">
                                        <?php echo __('Change Password'); ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</main>