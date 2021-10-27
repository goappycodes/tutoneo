<?php

use App\Models\User;
use App\Services\Auth;
use App\Services\FrontendAlertService;

?>
<header class="bg-light-tutoneo pt-9 pb-11 d-none d-md-block">
    <div class="container-md">
        <div class="row align-items-center">
            <div class="col">

                <!-- Heading -->
                <h1 class="font-weight-bold  mb-2">
                    <?php echo __('Account') ?>
                </h1>

                <!-- Text -->
                <p class="font-size-lg  mb-0">
                    <?php echo __('Welcome ') . Auth::user()->get_name() ?>
                </p>

                <?php if (Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE)) { ?> 
                <p class="font-size-lg  mb-0">
                    <?php echo __('My Credits: ') . Auth::user()->get_credit_points() ?>
                </p>
                <?php } ?>

                <?php if (Auth::has_role(User::TEACHER_ROLE)) { ?> 
                <p class="font-size-lg  mb-0">
                    <?php echo __('My Wallet: ') . Auth::user()->get_wallet_amount(true) ?>
                </p>
                <?php } ?>

            </div>
            <div class="col-auto">

                <a href="<?php echo wp_logout_url('/'); ?>" class="border-button">
                    <?php echo __('Log Out') ?>
                </a>

            </div>
        </div> <!-- / .row -->

        <?php FrontendAlertService::show_alerts(); ?>

        <?php if (!Auth::user()->is_teacher() && !Auth::user()->has_dominant_response()): ?>
        <div class="row pt-5">
            <div class="col-12">
                <div class="alert alert-warning">
                    <?php echo __('You have not filled up your dominant memory form') ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if (!Auth::user()->has_profile_pic()): ?>
        <div class="row pt-5">
            <div class="col-12">
                <div class="alert alert-warning">
                    <?php echo __('You have not uploaded your profile pic') ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div> <!-- / .container -->
</header>