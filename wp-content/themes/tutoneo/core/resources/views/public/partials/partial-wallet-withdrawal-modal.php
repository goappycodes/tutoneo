<?php

use App\Controllers\Frontend\TeacherWalletController;
use App\Services\Auth;

?>
<div class="modal fade show" id="wallet-withdraw-modal" tabindex="-1" aria-modal="true" role="dialog" style="padding-left: 17px;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

                <h2 class="font-weight-bold text-center mb-4">
                    <?php echo __('Wallet Withdrawal') ?>
                </h2>

                <form class="ajax-form" id="wallet-withdrawal-form">
                    <input type="hidden" name="action" value="<?php echo TeacherWalletController::WITHDRAWAL_ACTION ?>">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="amount"><?php echo __('Amount') ?></label>
                            <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter Amount" max="<?php echo Auth::user()->get_wallet_amount(); ?>" min="0">
                        </div>
                        <div class="col-12">
                            <button class="btn btn-block btn-success mt-3 lift">
                                <?php echo __('Withdraw') ?>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>