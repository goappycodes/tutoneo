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
                                                <form action="<?php echo get_page_url(Page::TOP_UP_PAYMENT) ?>" method="get">
                                                    <h4>Enter the valid amount</h4>
                                                    <input type="text" name="amount" placeholder="minimum 15€" class="form-control pop_up_amount_field" min="1">
                                                    <div class="w-100">
                                                        <input id="have_promocode" name="have_promocode" class="btn btn-primary" type="checkbox" data-toggle="collapse" data-target="#promoCode" aria-expanded="false" aria-controls="promoCode">
                                                        <label for="have_promocode">I have a promocode</label>
                                                    </div>   
                                                    <div class="collapse" id="promoCode">
                                                        <input type="text" id="promo_code_val" name="promocode" class="form-control" placeholder="Enter your promocode">
                                                        <p id="promo_msg"></p>
                                                        <div class="loader_wrapper text-center">
                                                            <div class="spinner-border text-success d-none" role="status">
                                                                <span class="invisible"></span>
                                                            </div>
                                                        </div>
                                                            
                                                        <input type="button" id="apply_promo_code" class="btn btn-success btn-xs mr-3 mt-2 w-100" value="Apply Code">
                                                        
                                                    </div>
                                                    <input type="submit" class="btn btn-success btn-xs mr-3 mt-2 w-100" value="Pay Now">
                                                    
                                                </form>
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

<?php 
 include_once('partials/partial-invalid-top-up-amount.php');

?>