<?php 

use App\Services\Auth;

$credit_points = Auth::user()->credit_points_history();

include_once('partials/partial-account-header.php');
?>

<main class="pb-8 pb-md-11 mt-md-n6">
    <div class="container-md">
        <div class="row">
            <?php include_once( 'partials/partial-account-sidebar.php') ?>
            <div class="col-12 col-md-9">
                <div class="card card-bleed shadow-light-lg mb-6">
                    <div class="card-header d-flex justify-content-space-between">
                        <h4 class="mb-0 font-weight-bold">
                            <?php echo __('Credit Points') ?>
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="wrapper-block-payments-details">
                            <?php foreach ($credit_points as $data) { ?> 
                                <div class="card card-border p-0 mb-6" data-aos="fade-up">
                                    <div class="card-body shadow-lg border-smooth card-pd-30 border-radius-standard">
                                        <div class="wrapper-info-booking payments-history-block">
                                            <div class="">
                                                <?php if ($data->payment()): ?>
                                                <div class="info-col">
                                                    <p class="font-weight-bold mr-2"> <?php echo __('Payment ID :') ?> </p>
                                                    <p class="font-size-sm text-muted"><?php echo $data->payment()->txn_id() ?></p>
                                                </div>
                                                <?php endif; ?>
                                                <div class="info-col">
                                                    <p class="font-weight-bold mr-2"> <?php echo __('Booking ID:') ?> </p>
                                                    <p class="font-size-sm text-muted"><?php echo $data->booking()->get_reference() ?></p>
                                                </div>
                                                <?php if ($data->lesson()): ?>
                                                <div class="info-col">
                                                    <p class="font-weight-bold mr-2"> <?php echo __('Lesson ID :') ?> </p>
                                                    <p class="font-size-sm text-muted"><?php echo $data->lesson()->get_reference() ?></p>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="">
                                                <div class="info-col">
                                                    <p class="font-weight-bold mr-2"> <?php echo __('Event :') ?> </p>
                                                    <p class="font-size-sm text-muted"><?php echo $data->get_event_text() ?></p>
                                                </div>
                                                <div class="info-col">
                                                    <p class="font-weight-bold mr-2"> <?php echo __('Date :') ?> </p>
                                                    <p class="font-size-sm text-muted"><?php echo $data->added_at() ?></p>
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="info-col">
                                                    <p class="font-size-sm text-muted">
                                                        <?php if ($data->is_debit()): ?>
                                                            <span class="alert alert-danger font-weight-bold">- <?php echo $data->credit_points() ?></span>
                                                        <?php else: ?>
                                                            <span class="alert alert-success font-weight-bold">+ <?php echo $data->credit_points() ?></span>
                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
    
                            <?php if (!count($credit_points)) { ?>
                            <div class="text-center text-muted">
                                <p><?php echo __('No data found') ?></p>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>