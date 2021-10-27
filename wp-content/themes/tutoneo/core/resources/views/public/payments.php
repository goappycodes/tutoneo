<?php 

use App\Services\Auth;

$payments = Auth::user()->payments();

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
                            <?php echo __('Payments') ?>
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="wrapper-block-payments-details">
                            <?php foreach ($payments as $payment) { ?> 
                                <div class="card card-border p-0 mb-6" data-aos="fade-up">
                                    <div class="card-body shadow-lg border-smooth card-pd-30 border-radius-standard">
                                        <div class="wrapper-info-booking payments-history-block">
                                            <div class="start-col">
                                                <div class="info-col">
                                                    <p class="font-weight-bold mr-2"> <?php echo __('Txn ID:') ?> </p>
                                                    <p class="font-size-14 text-muted"><?php echo $payment->txn_id() ?></p>
                                                </div>
                                                <div class="info-col">
                                                    <p class="font-weight-bold mr-2"> <?php echo __('Payment ID :') ?> </p>
                                                    <p class="font-size-14 text-muted"><?php echo $payment->payment_id() ?></p>
                                                </div>
                                            </div>
                                            <div class="middle-col">
                                                <?php if ($payment->booking()): ?>
                                                <div class="info-col">
                                                    <p class="font-weight-bold mr-2"> <?php echo __('Booking ID :') ?> </p>
                                                    <p class="font-size-14 text-muted"><?php echo $payment->get_booking_reference() ?></p>
                                                </div>
                                                <?php endif; ?>
                                                <div class="info-col">
                                                    <p class="font-weight-bold mr-2"> <?php echo __('Payment Date :') ?> </p>
                                                    <p class="font-size-14 text-muted"><?php echo $payment->payment_date() ?></p>
                                                </div>
                                            </div>
                                            <div class="end-col">                                                
                                                <?php if ($payment->is_credit()): ?>
                                                    <div class="alert alert-success font-weight-bold">
                                                        <?php echo $payment->amount(true) ?>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="alert alert-danger font-weight-bold">
                                                        <?php echo $payment->amount(true) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
    
                            <?php if (!count($payments)) { ?>
                            <div class="text-center text-muted">
                                <p><?php echo __('No payments found') ?></p>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>