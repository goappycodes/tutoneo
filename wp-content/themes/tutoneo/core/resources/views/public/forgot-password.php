<?php

use App\Config\Config;
use App\Models\Page;

?>
<section>
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center no-gutters min-vh-100">
            <div class="col-12 col-md-6 col-lg-4 py-8 py-md-11">

                <?php echo do_shortcode('[reset_password]'); ?>

                <p class="mb-0 font-size-sm text-muted">
                    Remember your password? <a href="<?php echo get_page_url(Page::SIGN_IN) ?>">Log in</a>
                </p>

            </div>
            <div class="col-lg-7 offset-lg-1 align-self-stretch d-none d-lg-block">

                <!-- Image -->
                <div class="h-100 w-cover bg-cover" style="background-image: url(<?php echo Config::IMG_DIR_URI . '/covers/cover-17.jpg' ?>);"></div>

                <!-- Shape -->
                <div class="shape shape-left shape-fluid-y svg-shim text-white">
                    <svg viewBox="0 0 100 1544" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h100v386l-50 772v386H0V0z" fill="currentColor" /></svg>
                </div>

            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</section>