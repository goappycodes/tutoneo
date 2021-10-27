<?php

use App\Config\Config;

?>
<div class="modal fade show" id="student-questionnaire-response-modal" tabindex="-1" aria-modal="true" role="dialog" style="padding-left: 17px;">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

                <h2 class="font-weight-bold text-center mb-1">
                    <?php echo __('Student Questionnaire Response') ?>
                </h2>

                <div id="questionnaire-table-section" class="pt-5">
                    <div class="loader text-center">
                        <img width="250" src="<?php echo Config::IMG_DIR_URI . '/gif/loader.gif'; ?>" alt="loading...">
                    </div>
                    <div id="questionnaire-table">
                        <!-- ajax response goes here -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>