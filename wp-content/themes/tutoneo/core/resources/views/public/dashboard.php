<?php

use App\Models\Page;
use App\Services\Auth;
use App\Models\User;

$lessons = Auth::user()->lessons(['numberposts' => 5]);
$bookings = Auth::user()->bookings(['numberposts' => 5]);
$total_lessons = count(Auth::user()->lessons());
$total_bookings = count(Auth::user()->bookings());

include_once('partials/partial-account-header.php');
?>

<main class="pb-8 pb-md-11 mt-md-n6">
    <div class="container-md">
        <div class="row">
            <?php include_once('partials/partial-account-sidebar.php') ?>
            <div class="col-12 col-md-9">
                <div class="card card-bleed shadow-light-lg mb-6 custom-card-dashboard">
                    <div class="card-header pd-card-header-cs d-flex justify-content-space-between">
                        <h4 class="mb-0 font-weight-bold">
                            <?php echo __('Dashboard') ?>
                        </h4>
                        <?php if (Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE)) { ?> 
                        <a href="<?php echo get_page_url(Auth::user()->is_student() ? Page::STUDENT_BOOKING : Page::PARENT_BOOKING) ?>" class="gform_previous_button ml-1">
                            <?php echo __('Make A New Booking') ?>
                        </a>
                        <?php } ?>
                    </div>
                    
                    <div class="card-body p-0">
                        <div class="card card-border border-highlight-success-tutoneo p-0 mb-6" data-aos="fade-up">
                            <div class="card-body shadow-lg border-smooth card-pd-30 border-radius-standard">
                                <a href="#">
                                    <h6 class="text-uppercase text-success-tutoneo  d-inline-block mb-5 mr-1">
                                        <?php echo __('Total Bookings') ?>
                                    </h6>
                                    <span class="badge badge-rounded-circle badge-success-tutoneo">
                                        <span><?php echo $total_bookings; ?></span>
                                    </span>
                                </a>
                                <div>
                                    <div class="list-group list-group-flush flex-upcoming-lessons">
                                        <div class="flex-sub-haeding-dashboard">
                                            <p class="font-weight-bold width-50">
                                                <?php echo __('Booking') ?>
                                            </p>
                                            <p class="font-weight-bold width-25">
                                                <?php echo __('Hours') ?>
                                            </p>
                                            <p class="font-weight-bold width-25">
                                                <?php echo __('Date') ?>
                                            </p>
                                        </div>
                                        <?php foreach($bookings as $booking) { ?> 
                                        <div class="flex-info-lesson">
                                            <a href="<?php echo get_page_url(Page::BOOKING_DETAILS) . '?ref=' . $booking->get_reference() ?>" class="width-50 text-muted">
                                                <p class="font-size-14 mb-2">
                                                    <?php echo $booking->get_title() ?>
                                                </p>
                                            </a>
                                            <p class="font-size-14 text-muted mb-2 width-25">
                                                <?php echo $booking->get_hours_booked() ?>
                                            </p>
                                            <p class="font-size-14 text-muted mb-2 width-25">
                                                <?php echo $booking->get_booking_date() ?>
                                            </p>
                                        </div>
                                        <?php } ?>
                                        <?php if (!$total_bookings) { ?> 
                                        <div class="row">
                                            <div class="col-md-12 text-center text-muted">
                                            <?php echo __('No booking found') ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    </div>
                                    <div class="button-group-dashboard mt-5">
                                        <a href="<?php echo get_page_url(Page::STUDENT_BOOKINGS) ?>" class="gform_next_button mr-1">
                                            <?php echo __('View all') ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-border border-highlight-primary-tutoneo p-0 mb-6" data-aos="fade-up">
                            <div class="card-body shadow-lg border-smooth card-pd-30 border-radius-standard">
                                <a href="#">
                                    <h6 class="text-uppercase text-primary-tutoneo d-inline-block mb-5 mr-1">
                                        <?php echo __('Total Lessons') ?>
                                    </h6>
                                    <span class="badge badge-rounded-circle badge-primary-tutoneo">
                                        <span><?php echo $total_lessons ?></span>
                                    </span>
                                </a>
                                <div>
                                    <div class="list-group list-group-flush flex-upcoming-lessons">
                                        <div class="flex-sub-haeding-dashboard">
                                            <p class="font-weight-bold width-50">
                                                <?php echo __('Lessons') ?>
                                            </p>
                                            <p class="font-weight-bold width-25">
                                                <?php echo __('Tutor') ?>
                                            </p>
                                            <p class="font-weight-bold width-25">
                                                <?php echo __('Date/Time') ?>
                                            </p>
                                        </div>
                                        <?php foreach($lessons as $lesson) { ?> 
                                        <div class="flex-info-lesson">
                                            <a href="#" class="width-50 text-muted">
                                                <p class="font-size-14 text-muted mb-2">
                                                    <?php echo $lesson->get_title() ?>
                                                </p>
                                            </a>
                                            <p class="font-size-14 text-muted mb-2 width-25">
                                                <?php echo $lesson->get_teacher_name() ?>
                                            </p>
                                            <p class="font-size-14 text-muted mb-2 width-25">
                                                <?php echo $lesson->get_start_time('d M, Y, h:i A') ?>
                                            </p>
                                        </div>
                                        <?php } ?>
                                        <?php if (!$total_lessons) { ?> 
                                        <div class="row">
                                            <div class="col-md-12 text-center text-muted">
                                            <?php echo __('No lesson found') ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="button-group-dashboard mt-5">
                                        <a href="<?php echo get_page_url(
                                            Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE) ? Page::STUDENT_LESSONS : Page::TEACHER_LESSONS
                                        ) ?>" class="gform_next_button">
                                            <?php echo __('Lesson Calendar') ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
