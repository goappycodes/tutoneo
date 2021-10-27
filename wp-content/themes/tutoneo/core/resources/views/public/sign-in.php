<?php

use App\Controllers\Frontend\SignInController;
use App\Models\Page;
?>
<section>
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center no-gutters min-vh-100">
            <div class="col-12 col-md-6 col-lg-4 py-8 py-md-11">

                <!-- Heading -->
                <h1 class="mb-0 font-weight-bold">
                    <?php echo __('Sign in'); ?>
                </h1>

                <!-- Text -->
                <p class="mb-6 text-muted">
                    <?php echo __('Simplify your workflow in minutes.'); ?>

                </p>

                <!-- Form -->
                <form class="mb-6 ajax-form" id="sign-in-form">

                    <input type="hidden" name="action" value="<?php echo SignInController::SIGNIN_ACTION ?>">
                    <!-- Username -->
                    <div class="form-group">
                        <label for="username">
                            <?php echo __('Username'); ?>
                        </label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username">
                    </div>

                    <!-- Password -->
                    <div class="form-group mb-5">
                        <label for="password">
                            <?php echo __('Password'); ?>
                        </label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
                    </div>

                    <div class="form-group mb-5">
                        <input type="checkbox" name="remember" id="remember" value="1">
                        <label for="remember">
                            <?php echo __('Remember Me'); ?>
                        </label>
                    </div>

                    <!-- Submit -->
                    <button class="btn btn-block btn-primary" type="submit">
                        <?php echo __('Sign in'); ?>
                    </button>

                </form>

                <p class="mb-0 font-size-sm text-muted text-right">
                    <a href="<?php echo get_page_url(Page::FORGOT_PASSWORD) ?>">Forgot Password?</a>
                </p>

            </div>
            <div class="col-lg-7 offset-lg-1 align-self-stretch d-none d-lg-block">

                <!-- Image -->
                <div class="h-100 w-cover bg-cover" style="background-image: url(<?php echo \App\Config\Config::IMG_DIR_URI . '/covers/cover-14.jpg' ?>);"></div>

                <!-- Shape -->
                <div class="shape shape-left shape-fluid-y svg-shim text-white">
                    <svg viewBox="0 0 100 1544" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h100v386l-50 772v386H0V0z" fill="currentColor" /></svg>
                </div>

            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</section>