<?php

use App\Services\FrontendAlertService;

$alert_type = FrontendAlertService::get_type();
$alert_message = FrontendAlertService::get_message();

if ($alert_type == 'error') {
    $alert_type = 'danger';
}

?>

<div class="row pt-5">
    <div class="col-12">
        <div class="alert alert-<?php echo $alert_type ?>">
            <?php echo $alert_message ?>
        </div>
    </div>
</div>