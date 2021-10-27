<?php

use App\Models\User;
use App\Services\Auth;

include_once('partials/partial-account-header.php')
?>

<!-- MAIN
    ================================================== -->
<main class="pb-8 pb-md-11 mt-md-n6">
    <div class="container-md">
        <div class="row">
            <?php include_once('partials/partial-account-sidebar.php') ?>
            <div class="col-12 col-md-9">

                <?php 
                if (Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE)) {
                    include_once('partials/partial-student-profile-form.php');
                } else if (Auth::has_role(User::TEACHER_ROLE)) {
                    include_once('partials/partial-teacher-profile-form.php');
                }
                ?>

            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</main>