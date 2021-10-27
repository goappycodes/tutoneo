<?php

use App\Controllers\Frontend\TeacherBankDetailsController;
use App\Models\TeacherUser;
use App\Services\Auth;

include_once('partials/partial-account-header.php');
?>

<main class="pb-8 pb-md-11 mt-md-n6">
    <div class="container-md">
        <div class="row">
            <?php include_once( 'partials/partial-account-sidebar.php') ?>
            <div class="col-12 col-md-9">
                <form action="#" class="ajax-form">
                    <input type="hidden" name="action" value="<?php echo TeacherBankDetailsController::SAVE_DETAILS_ACTION ?>">
                    <div class="card card-bleed shadow-light-lg mb-6">
                        <div class="card-header d-flex justify-content-space-between">
                            <h4 class="mb-0 font-weight-bold">
                                <?php echo __('Bank Details') ?>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="bank_name"><?php echo __('Bank Name') ?></label>
                                    <input type="text" name="bank_name" id="bank_name" value="<?php echo Auth::user()->get_meta(TeacherUser::BANK_NAME) ?>" placeholder="<?php echo __('Bank Name') ?>" class="form-control" />
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="bank_bic"><?php echo __('BIC') ?></label>
                                    <input type="text" name="bank_bic" id="bank_bic" value="<?php echo Auth::user()->get_meta(TeacherUser::BANK_BIC) ?>" placeholder="<?php echo __('BIC') ?>" class="form-control" />
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="bank_iban"><?php echo __('IBAN') ?></label>
                                    <input type="text" name="bank_iban" id="bank_iban" value="<?php echo Auth::user()->get_meta(TeacherUser::BANK_IBAN) ?>" placeholder="<?php echo __('IBAN') ?>" class="form-control" />
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="bank_country"><?php echo __('Bank Country') ?></label>
                                    <input type="text" name="bank_country" id="bank_country" value="<?php echo Auth::user()->get_meta(TeacherUser::BANK_COUNTRY) ?>" placeholder="<?php echo __('Bank Country') ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="bank_address"><?php echo __('Bank Address') ?></label>
                                    <textarea type="text" name="bank_address" id="bank_address" value="" placeholder="<?php echo __('Bank Address') ?>" class="form-control" rows="3"><?php echo Auth::user()->get_meta(TeacherUser::BANK_ADDRESS) ?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="beneficiary_name"><?php echo __('Beneficiary Name') ?></label>
                                    <input type="text" name="beneficiary_name" id="beneficiary_name" value="<?php echo Auth::user()->get_meta(TeacherUser::BENEFICIARY_NAME) ?>" placeholder="<?php echo __('Beneficiary Name') ?>" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="gform_next_button">
                                        <?php echo __('Save') ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>