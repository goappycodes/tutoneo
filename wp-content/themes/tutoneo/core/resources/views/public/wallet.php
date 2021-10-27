<?php 

use App\Services\Auth;

$teacher_ledgers = Auth::user()->teacher_ledgers();

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
                            <?php echo __('Wallet Payments') ?>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="wrapper-block-payments-details">
                            <?php foreach ($teacher_ledgers as $teacher_ledger) { ?> 
                                <div class="card card-border p-0 mb-6" data-aos="fade-up">
                                    <div class="card-body shadow-lg border-smooth card-pd-30 border-radius-standard">
                                        <div class="wrapper-info-booking payments-history-block">
                                            <div class="start-col">
                                                <div class="info-col">
                                                    <p class="font-weight-bold mr-2"> <?php echo __('Ref ID :') ?> </p>
                                                    <p class="font-size-sm text-muted"><?php echo $teacher_ledger->get_reference() ?></p>
                                                </div>
                                            <?php if ($teacher_ledger->is_payout()): ?>
                                            </div>  
                                            <div>
                                            <?php endif; ?>
                                                <div class="info-col">
                                                    <p class="font-weight-bold mr-2"> <?php echo __('Date :') ?> </p>
                                                    <p class="font-size-sm text-muted"><?php echo $teacher_ledger->get_date() ?></p>
                                                </div>
                                            </div>
                                            <?php if ($teacher_ledger->is_earning()): ?>
                                            <div class="middle-col">
                                                <div class="info-col">
                                                    <p class="font-weight-bold mr-2"> <?php echo __('Lesson ID :') ?> </p>
                                                    <p class="font-size-sm text-muted"><?php echo $teacher_ledger->lesson()->get_reference() ?></p>
                                                </div>
                                                <div class="info-col">
                                                    <p class="font-weight-bold mr-2"> <?php echo __('Booking ID :') ?> </p>
                                                    <p class="font-size-sm text-muted"><?php echo $teacher_ledger->booking()->get_reference() ?></p>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <div class="end-col">
                                                <div class="alert alert-<?php echo $teacher_ledger->get_alert_class() ?> font-weight-bold text-center">
                                                    <?php echo $teacher_ledger->amount(true) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if (!count($teacher_ledgers)) { ?>
                            <div class="text-center text-muted">
                                <p><?php echo __('No transactions found') ?></p>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include_once('partials/partial-wallet-withdrawal-modal.php'); ?>