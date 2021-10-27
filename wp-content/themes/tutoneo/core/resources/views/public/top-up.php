<?php 

use App\Services\Auth;
use App\Models\Page;

$bookings = Auth::user()->bookings();

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
                            <?php echo __('Top Up') ?>
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="wrapper-block-payments-details">
                            <div class="card card-border p-0 mb-6" data-aos="fade-up">
                                <div class="card-body shadow-lg border-smooth card-pd-30 border-radius-standard">
                                    <div class="wrapper-info-booking payments-history-block">
                                        <div class="top_up_details">
                                            <div class="info-col">
                                                <h4 class="font-weight-bold"><?php echo __('Top Up You Wallet Now'); ?></h4>
                                                <p class="font-size-sm text-muted">
                                                    0€ - 35€ -> +0%<br>
                                                    36€ - 100€ ->+15%<br>
                                                    101€ - 200€ -> +20%<br>
                                                    +201€ -> +25%<br>
                                                </p>
                                            </div>
                                            <div class="infp-col">
                                                <h4>Enter the valid amount</h4>
                                                <input type="text" placeholder="minimum 15€" class="form-control pop_up_amount_field">
                                                <input type="submit" class="gform_next_button pop_up_amount_submit" href="<?php echo get_page_url(Page::TOP_UP_PAYMENT) ?>">
                                            </div>
                                        </div>
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