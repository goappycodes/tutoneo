<?php

use App\Models\DominantMemoryForm;

include_once('partials/partial-account-header.php');
?>
<main class="pb-8 pb-md-11 mt-md-n6">
    <div class="container-md">
        <div class="row">
            <?php include_once('partials/partial-account-sidebar.php') ?>
            <div class="col-12 col-md-9">

                <!-- Card -->
                <div class="card card-bleed shadow-light-lg mb-6">
                    <div class="card-header">

                        <!-- Heading -->
                        <h4 class="mb-0 font-weight-bold">
                            <?php echo __('Dominant Memory') ?>
                        </h4>

                    </div>
                    <div class="card-body">
                       <?php echo do_shortcode('[gravityform id="'.DominantMemoryForm::ID.'" title="false" description="false" ajax="true"]') ?>
                    </div>
                </div>

            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</main>