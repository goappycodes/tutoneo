<?php
/**
* Template Name: Account: Messages
*
*/

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );

?>

<!-- HEADER
================================================== -->
<header class="bg-dark pt-9 pb-11 d-none d-md-block">
  <div class="container-md">
    <div class="row align-items-center">
      <div class="col">

        <!-- Heading -->
        <h1 class="font-weight-bold text-white mb-2">
          Account Settings
        </h1>

        <!-- Text -->
        <p class="font-size-lg text-white-75 mb-0">
          Settings for <a class="text-reset" href="mailto:dhgamache@gmail.com">dhgamache@gmail.com</a>
        </p>

      </div>
      <div class="col-auto">

        <!-- Button -->
        <button class="btn btn-sm btn-gray-300-20">
          Log Out
        </button>

      </div>
    </div> <!-- / .row -->
  </div> <!-- / .container -->
</header>


<!-- MAIN
================================================== -->
<main class="pb-8 pb-md-11 mt-md-n6">
  <div class="container-md">
    <div class="row">
      <div class="col-12 col-md-3">

        <!-- Card -->
        <div class="card card-bleed border-bottom border-bottom-md-0 shadow-light-lg">

          <!-- Collapse -->
          <div class="collapse d-md-block" id="sidenavCollapse">
            <div class="card-body">

              <!-- Heading -->
              <h6 class="font-weight-bold text-uppercase mb-3">
                Account
              </h6>

              <!-- List -->
              <ul class="card-list list text-gray-700 mb-6">
                <li class="list-item">
                  <a class="list-link text-reset" href="account-general.html">
                    General
                  </a>
                </li>
                <li class="list-item">
                  <a class="list-link text-reset" href="account-security.html">
                    Security
                  </a>
                </li>
                <li class="list-item">
                  <a class="list-link text-reset" href="account-notifications.html">
                    Notifications
                  </a>
                </li>
              </ul>

              <!-- Heading -->
              <h6 class="font-weight-bold text-uppercase mb-3">
                Billing
              </h6>

              <!-- List -->
              <ul class="card-list list text-gray-700 mb-0">
                <li class="list-item active">
                  <a class="list-link text-reset" href="billing-plans-and-payment.html">
                    Plans & Payment
                  </a>
                </li>
                <li class="list-item">
                  <a class="list-link text-reset" href="billing-users.html">
                    Users
                  </a>
                </li>
              </ul>

            </div>
          </div>

        </div>

      </div>
      <div class="col-12 col-md-9">

        <!-- Card -->
        <div class="card card-bleed shadow-light-lg mb-6">
          <div class="card-header">
            <div class="row align-items-center">
              <div class="col">

                <!-- Heading -->
                <h4 class="mb-0">
                  Current Plan
                </h4>

              </div>
              <div class="col-auto">

                <!-- Price -->
                <span class="h4 font-weight-bold">
                  $29/mo
                </span>

              </div>
            </div>
          </div>
          <div class="card-body">

            <!-- Header -->
            <div class="row mb-5">
              <div class="col">
                <?php echo do_shortcode('[front-end-pm]'); ?>
              </div>
            </div>
            
          </div>
          
        </div>
      </div>
    </div> <!-- / .row -->
  </div> <!-- / .container -->
</main>

<?php get_footer(); ?>