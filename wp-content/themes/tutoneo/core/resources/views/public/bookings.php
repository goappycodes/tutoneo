<?php

use App\Controllers\Frontend\BookingsController;
use App\Models\Page;
use App\Models\User;
use App\Services\Auth;
use App\Models\Booking;

$bookings = Auth::user()->bookings();

include_once('partials/partial-account-header.php');
?>

<main class="pb-8 pb-md-11 mt-md-n6">
    <div class="container-md">
        <div class="row">
            <?php include_once('partials/partial-account-sidebar.php') ?>
            <div class="col-12 col-md-9">

                <div class="card card-bleed shadow-light-lg mb-6">
                    <div class="card-header d-flex justify-content-space-between">

                        <h4 class="mb-0 font-weight-bold">
                            <?php echo __('Bookings') ?>
                        </h4>

                        <?php if (Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE)) { ?>
                            <a href="<?php echo get_page_url(Auth::user()->is_student() ? Page::STUDENT_BOOKING : Page::PARENT_BOOKING) ?>" class="btn btn-primary btn-xs">
                                <?php echo __('Book Now') ?>
                            </a>
                        <?php } ?>

                    </div>
                    <div class="card-body booking-list">
                        <?php foreach ($bookings as $booking) { ?>
                            <div class="block-booking shadow-lg border-smooth card-pd-30 border-radius-standard">
                                <?php //if (Auth::user()->is_teacher() && !$booking->has_successful_payment()): 
                                ?>
                                <?php if ($booking->user()->get_credit_points() < 10) : ?>
                                    <div class="row">
                                        <div class="col-md-12 form-group text-center">
                                            <span class="badge badge-danger">
                                                <?php echo __('This booking is on hold as the student has insufficient amount in his/her wallet.') ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="wrapper-header-booking">
                                    <div class="title-booking d-flex align-items-center">
                                        <?php if (Auth::user()->is_teacher()) : ?>
                                            <img src="<?php echo $booking->user()->get_profile_pic() ?>" alt="image" width="50" height="50" class="rounded-circle">
                                        <?php elseif ($booking->has_teacher()) : ?>
                                            <img src="<?php echo $booking->teacher()->get_profile_pic() ?>" alt="image" width="50" height="50" class="rounded-circle">
                                        <?php endif; ?>
                                        <h4 class="ml-3 mb-0"><?php echo $booking->get_title() ?></h4>
                                    </div>
                                    <div class="right-buttons-cs">
                                        <div class="button-group-dashboard">
                                            <a href="<?php echo get_page_url(Page::BOOKING_DETAILS) . '?ref=' . $booking->get_reference() ?>" class="gform_next_button mr-1 form-group">
                                                <?php echo __('View Booking') ?>
                                            </a>

                                            <?php if (Auth::user()->can_chat_with_teacher($booking)) : ?>
                                                <a href="<?php echo $booking->teacher()->get_chat_link(Auth::user()->get_id(), $booking->get_id()) ?>" class="gform_previous_button ml-1">
                                                    <?php echo __('Chat with Teacher') ?>
                                                </a>
                                            <?php endif; ?>
                                            <!-- previous logic -->
                                            <?php //if (Auth::user()->can_manage_lessons($booking)): 
                                            ?>
                                            <!-- <a href="<?php //echo get_page_url(Page::TEACHER_LESSONS) . '?action=add&booking=' . $booking->get_reference() 
                                                            ?>" class="gform_previous_button ml-1">
                                            <?php //echo __('Add Lesson') 
                                            ?>
                                        </a> -->
                                            <?php //endif; 
                                            ?>

                                            <?php if (Auth::user()->is_teacher() && $booking->user()->get_credit_points() > 10) : ?>
                                                <?php
                                                // echo "<pre>";
                                                // print_r(get_user_by('email' , 'bappa@appycodes.com'));
                                                // exit;
                                                ?>
                                                <a href="<?php echo get_page_url(Page::TEACHER_LESSONS) . '?action=add&booking=' . $booking->get_reference() ?>" class="gform_previous_button ml-1">
                                                    <?php echo __('Add Lesson') ?>
                                                </a>
                                            <?php endif; ?>

                                            <?php if (Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE) && $booking->user()->get_credit_points() > 10) : ?>
                                                <a href="<?php echo get_page_url(Page::STUDENT_LESSONS) . '?action=add&booking=' . $booking->get_reference() ?>" class="gform_previous_button ml-1">
                                                    <?php echo __('Add Lesson') ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <p class="font-weight-bold mr-2"> <?php echo __('Reference :') ?> </p>
                                        <p class="font-size-14 text-muted"><?php echo $booking->get_reference() ?></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="font-weight-bold mr-2"> <?php echo __('User :') ?> </p>
                                        <p class="font-size-14 text-muted"><?php echo $booking->get_user_full_name() ?></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="font-weight-bold mr-2"> <?php echo __('Teacher :') ?> </p>
                                        <p class="font-size-14 text-muted"><?php echo $booking->get_teacher_or_not_assigned_label() ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p class="font-weight-bold mr-2"> <?php echo __('Date :') ?> </p>
                                        <p class="font-size-14 text-muted"><?php echo $booking->get_booking_date() ?></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="font-weight-bold mr-2"> <?php echo __('Email :') ?> </p>
                                        <p class="font-size-14 text-muted"><?php echo $booking->get_user_email() ?></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="font-weight-bold mr-2"> <?php echo __('Hours Available :') ?> </p>
                                        <p class="font-size-14 text-muted">
                                            <?php if ($booking->has_successful_payment()) : ?>
                                                <?php echo $booking->credits_left() . ' of ' . $booking->get_hours_booked() ?>
                                            <?php else : ?>
                                                <?php echo $booking->get_hours_booked() ?>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <?php if (Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE)) { ?>
                                        <div class="col-md-4">
                                            <div class="status-payments">
                                                <p class="font-weight-bold mr-2"> <?php echo __('Payment Status :') ?> </p>
                                                <p><?php echo $booking->get_payment_status_label() ?></p>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="col-md-4">
                                        <p class="font-weight-bold mr-2"> <?php echo __('Status :') ?> </p>
                                        <p><?php echo $booking->get_status_label() ?></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="font-weight-bold mr-2"> <?php echo __('Payer Mail:') ?> </p>
                                        <p class="font-size-14 text-muted"><?php echo $booking->get_payer_email() ?></p>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-12">
                                        <?php //if (Auth::user()->can_pay_for_booking($booking)): 
                                        ?>
                                        <!-- <a target="_blank" href="<?php //echo $booking->get_payment_link() 
                                                                        ?>" class="btn btn-success btn-xs mr-3">
                                        <?php //echo __('Pay Now') 
                                        ?>
                                    </a> -->
                                        <?php //endif; 
                                        ?>

                                        <?php if ($booking->completed() && Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE)) : ?>
                                            <div class="dropdown d-inline mr-3">
                                                <button class="btn btn-primary btn-xs dropdown-toggle" type="button" id="bookingAction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <?php echo __('Book Again') ?>
                                                </button>
                                                <div class="dropdown-menu rebooking dropdown-menu-xs" aria-labelledby="bookingAction">
                                                    <form action="#" class="ajax-form clone-booking-form">
                                                        <input type="hidden" name="action" value="<?php echo BookingsController::CLONE_BOOKING_ACTION ?>">
                                                        <input type="hidden" name="reference_no" value="<?php echo $booking->get_reference() ?>">
                                                    </form>
                                                    <form action="#" class="ajax-form clone-booking-without-teacher-form">
                                                        <input type="hidden" name="action" value="<?php echo BookingsController::CLONE_WITHOUT_TEACHER_ACTION ?>">
                                                        <input type="hidden" name="reference_no" value="<?php echo $booking->get_reference() ?>">
                                                    </form>
                                                    <a class="dropdown-item clone-booking" href="javascript:;"><?php echo __('Same Course, Same Teacher') ?></a>
                                                    <a class="dropdown-item clone-booking-without-teacher" href="javascript:;"><?php echo __('Same Course, Different Teacher') ?></a>
                                                    <a class="dropdown-item" href="<?php echo get_page_url(Auth::user()->is_student() ? Page::STUDENT_BOOKING : Page::PARENT_BOOKING) ?>"><?php echo __('Different Course') ?></a>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (Auth::has_role(User::TEACHER_ROLE) && $booking->user()->has_dominant_response()) : ?>
                                            <a href="javascript:;" data-booking="<?php echo $booking->get_reference() ?>" class="btn btn-primary btn-xs mr-3 show-dominant-memory-modal">
                                                <?php echo __('Dominant Memory') ?>
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($booking->has_questionnaire_response()) : ?>
                                            <a href="javascript:;" data-booking="<?php echo $booking->get_reference() ?>" class="btn btn-primary btn-xs show-student-questionnaire-response">
                                                <?php echo __('Questionnaire Response') ?>
                                            </a>
                                        <?php endif; ?>
                                        <a href="javascript:;" data-booking="<?php echo $booking->get_reference() ?>" class="btn btn-danger btn-xs report-booking float-right">
                                            <?php echo __('Report') ?>
                                        </a>
                                        <?php if (Auth::user()->can_cancel_booking($booking)) : ?>
                                            <a href="javascript:;" data-booking="<?php echo $booking->get_reference() ?>" class="btn btn-danger btn-xs cancel-booking float-right">
                                                <?php echo __('Cancel') ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php
                                $id = $booking->user()->get_id();
                                $user_info = get_field('user_info', 'user_' . $id);
                                if (Auth::user()->is_teacher() && !empty($user_info)) : ?>
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <a href="#userInfoSection-<?php echo $booking->get_reference() ?>" data-toggle="collapse" class="show-user-info ">
                                                <?php echo __('User Info' . get_icon('/duotone-icons/Navigation', 'Angle-down.svg')) ?>
                                            </a>
                                            <div id="userInfoSection-<?php echo $booking->get_reference() ?>" class="text-left collapse rounded border p-2">
                                                <p>
                                                    <?php
                                                    echo  __($user_info);
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-center">
                                            <?php if ($booking->has_lessons()) : ?>
                                                <a href="#booking-lessons-<?php echo $booking->get_reference() ?>" data-toggle="collapse" class="show-booking-lessons">
                                                    <?php echo __('Lessons(' . count($booking->lessons()) . ')' . get_icon('/duotone-icons/Navigation', 'Angle-down.svg')) ?>
                                                </a>
                                            <?php endif; ?>
                                            <div id="booking-lessons-<?php echo $booking->get_reference() ?>" class="collapse text-left">
                                                <?php foreach ($booking->datewise_sorted_lessons() as $lesson) : ?>
                                                    <div class="row mt-5">
                                                        <div class="col-12">
                                                            <div class="card bg-gray-300">
                                                                <div class="card-header p-4">
                                                                    <h4 class="mb-0 font-weight-bold d-flex justify-content-space-between">
                                                                        <?php echo $lesson->get_title() ?>
                                                                        <?php //echo $lesson->get_id() 
                                                                        ?>
                                                                        <span class="">
                                                                            <a href="<?php echo get_page_url(
                                                                                            Auth::has_role(User::TEACHER_ROLE) ? Page::TEACHER_LESSONS : Page::STUDENT_LESSONS
                                                                                        ) . "?lesson=" . $lesson->get_reference()
                                                                                        ?>"> <?php echo __('View in Calendar') ?> </a>
                                                                            <?php ?>
                                                                        </span>
                                                                    </h4>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="font-weight-bold font-medium">
                                                                                <?php echo __('Reference No:') ?>
                                                                            </div>
                                                                            <div class="text-muted">
                                                                                <?php echo $lesson->get_reference() ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="font-weight-bold font-medium">
                                                                                <?php echo __('Status:') ?>
                                                                            </div>
                                                                            <div class="text-muted">
                                                                                <?php if ($lesson->completed()) : ?>
                                                                                    <span class="badge badge-success"><?php echo __('Completed') ?></span>
                                                                                <?php else : ?>
                                                                                    <span class="badge badge-primary"><?php echo __('Upcoming') ?></span>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="font-weight-bold font-medium">
                                                                                <?php echo __('Start Time:') ?>
                                                                            </div>
                                                                            <div class="text-muted">
                                                                                <?php echo $lesson->get_start_time("d M, 'y, h:i A") ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="font-weight-bold font-medium">
                                                                                <?php echo __('End Time:') ?>
                                                                            </div>
                                                                            <div class="text-muted">
                                                                                <?php echo $lesson->get_end_time("d M, 'y, h:i A") ?>
                                                                            </div>
                                                                        </div>
                                                                        <?php if ($lesson->get_launch_url() && $lesson->can_be_modified()) : ?>
                                                                            <div class="col-md-6">
                                                                                <div class="font-weight-bold font-medium">
                                                                                    <?php echo __('Join Lesson:') ?>
                                                                                </div>
                                                                                <div class="text-muted">
                                                                                    <a href="<?php echo $lesson->get_launch_url(); ?>" target="_blank" class="btn btn-primary btn-xs mr-3">
                                                                                        <?php echo __('Join Lesson') ?>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                                <?php if (Auth::user()->is_teacher() && $lesson->can_be_modified()) : ?>
                                                                    <div class="card-footer">
                                                                        <div class="text-center">
                                                                            <a href="javascript:;" data-lesson="<?php echo $lesson->get_reference() ?>" data-payer_mail="<?php echo $lesson->get_payer_mail() ?>" data-start="<?php echo $lesson->get_start_time() ?>" class="btn btn-xs btn-primary lesson-action">
                                                                                <?php echo __('Take a Action!') ?>
                                                                               
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!count($bookings)) { ?>
                            <div class="text-center text-muted">
                                <p><?php echo __('No bookings found') ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</main>

<?php
include_once('partials/partial-dominant-memory-modal.php');
include_once('partials/partial-student-questionnaire-response-modal.php');
include_once('partials/partial-lesson-action-modal.php');
include_once('partials/partial-lesson-cancel-modal.php');
include_once('partials/partial-lesson-complete-confirmation.php');
include_once('partials/partial-lesson-reschedule-modal.php');

include_once('partials/partial-report-problem.php');
?>