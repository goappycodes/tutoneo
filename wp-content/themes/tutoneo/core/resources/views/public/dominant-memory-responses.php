<?php 

use App\Services\Auth;

$responses = Auth::user()->get_dominant_memory_responses();

include_once('partials/partial-account-header.php');
?>

<!-- MAIN
    ================================================== -->
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
                            <?php echo __('Dominant Memory Responses') ?>
                        </h4>

                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tbody>
                            <?php foreach ($responses as $label => $response): ?>
                                <tr>
                                    <th><?php echo $label ?></th>
                                    <td><?php echo $response; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</main>