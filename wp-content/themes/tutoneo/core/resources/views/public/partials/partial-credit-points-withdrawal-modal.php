<?php

use App\Controllers\Frontend\PaymentsController;
use App\Services\Auth;

?>
<div class="modal fade show" id="credit-points-withdrawal-modal" tabindex="-1" aria-modal="true" role="dialog" style="padding-left: 17px;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

                <h2 class="font-weight-bold text-center mb-4">
                    <?php echo __('Withdrawal') ?>
                </h2>

                <form class="ajax-form" id="credit-points-withdrawal-form">
                    <input type="hidden" name="action" value="<?php echo PaymentsController::WITHDRAW_ACTION; ?>">
                    <input type="hidden" name="txn_id">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="credit_points"><?php echo __('Credit Points') ?></label>
                            <input type="number" name="credit_points" id="credit_points" class="form-control" placeholder="Enter Credit Points to Withdraw" min="0">
                        </div>
                        <div class="col-12 form-group">
                            <label for="amount"><?php echo __('Amount') ?></label>
                            <div class="alert alert-info p-2">
                                <span class="converted_amount"></span>
                            </div>
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