<?php

use App\Models\User;
use App\Services\Auth;
use App\Models\Booking;
use App\Controllers\Frontend\BookingsController;

$bookings_controller = BookingsController::init();
$booking = Booking::find_by_ref($_GET['ref']);

include_once('partials/partial-account-header.php')
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
                            <?php echo $booking->get_title() ?>
                        </h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <tr>
                                    <th><?php echo __('Reference') ?></th>
                                    <td><?php echo $booking->get_reference(); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo __('Date') ?></th>
                                    <td><?php echo $booking->get_booking_date(); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo __('User') ?></th>
                                    <td><?php echo $booking->get_user_full_name(); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo __('User email') ?></th>
                                    <td><?php echo $booking->get_user_email(); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo __('Address') ?></th>
                                    <td><?php echo $booking->get_user_full_address(); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo __('Phone No.') ?></th>
                                    <td><?php echo $booking->get_phone_number(); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo __('Skype Id') ?></th>
                                    <td><?php echo $booking->get_skype_id(); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo __('Zoom Id') ?></th>
                                    <td><?php echo $booking->get_zoom_id(); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo __('Status') ?></th>
                                    <td><?php echo $booking->get_status_label() ?></td>
                                </tr>
                                <?php if (Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE)) : ?>
                                    <tr>
                                        <th><?php echo __('Payment Status') ?></th>
                                        <td>
                                            <?php echo $booking->get_payment_status_label() ?>
                                            <?php if (!$booking->has_successful_payment() && $booking->has_teacher()) : ?>
                                                <a target="_blank" href="<?php echo $booking->get_payment_link() ?>" class="btn btn-success btn-xs ml-3 ">
                                                    <?php echo __('Pay Now') ?>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <?php if ($booking->has_third_party_payment()) : ?>
                                        <tr>
                                            <th><?php echo __('Payer\'s Name') ?></th>
                                            <td><?php echo $booking->get_payer_full_name(); ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo __('Payer\'s Email') ?></th>
                                            <td><?php echo $booking->get_payer_email(); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</main>