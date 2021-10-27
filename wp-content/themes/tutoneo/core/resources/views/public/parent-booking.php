<?php

use App\Models\ParentBookingForm;

?>
<header class="bg-light-tutoneo pt-9 pb-11 d-none d-md-block">
    <div class="container-md">
        <div class="row justify-content-lg-center">
            <div class="col-12 col-md-9 col-lg-9">
                <h1 class="font-weight-bold mb-2 text-center">
                    <?php echo __('Make a Booking – Parents') ?>
                </h1>
                <p class="text-center">
                    <?php echo __('We keep everything as simple as possible by standardizing the <br />application process for all jobs.') ?>
                </p>
            </div>
        </div>
    </div>
</header>

<main class="pb-8 pb-md-11 mt-md-n6">
    <div class="container-md">
        <div class="row justify-content-lg-center">
            <div class="col-12 col-md-9 col-lg-9">
                <div class="card card-bleed shadow-light-lg mb-6">
                    <div class="card-body">
                        <?php echo do_shortcode('[gravityform id="' . ParentBookingForm::ID . '" title="false" description="false" ajax="true"]') ?>
                    </div>
                </div>
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</main>