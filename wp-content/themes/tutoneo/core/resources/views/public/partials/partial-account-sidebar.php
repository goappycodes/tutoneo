<?php

use App\Models\Page;
use App\Models\User;
use App\Services\Auth;
use App\Services\PageService;

?>
<div class="col-12 <?php echo PageService::is_current_page([Page::STUDENT_LESSONS, Page::TEACHER_LESSONS]) ? '' : 'col-md-3' ?>">

    <!-- Card -->
    <div class="card card-bleed border-bottom border-bottom-md-0 shadow-light-lg">

        <!-- Collapse -->
        <div class="collapse d-md-block" id="sidenavCollapse">
            <div class="card-body">

                <!-- Heading -->
                <h6 class="font-weight-bold text-uppercase mb-3">
                    <?php echo __('Account') ?>
                </h6>

                <!-- List -->
                <ul class="card-list list text-gray-700 mb-6">
                    <li class="list-item <?php echo PageService::is_current_page([Page::STUDENT_DASHBOARD, Page::TEACHER_DASHBOARD]) ? 'active' : '' ?>">
                        <a class="list-link text-reset" href="<?php echo get_page_url(
                                                Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE) ? Page::STUDENT_DASHBOARD : Page::TEACHER_DASHBOARD
                                            ) ?>">
                            <?php echo __('Dashboard') ?>
                        </a>
                    </li>
                    <li class="list-item <?php echo PageService::is_current_page([Page::STUDENT_PROFILE, Page::TEACHER_PROFILE]) ? 'active' : '' ?>">
                        <a class="list-link text-reset" href="<?php echo get_page_url(
                                                Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE) ? Page::STUDENT_PROFILE : Page::TEACHER_PROFILE
                                            ) ?>">
                            <?php echo __('Profile') ?>
                        </a>
                    </li>
                    <?php if (Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE)) { ?> 
                    <li class="list-item <?php echo PageService::is_current_page(Page::STUDENT_DOMINANT_MEMORY) ? 'active' : '' ?>">
                        <a class="list-link text-reset" href="<?php echo get_page_url(Page::STUDENT_DOMINANT_MEMORY) ?>">
                            <?php echo __('Dominant Memory') ?>
                        </a>
                    </li>
                    <?php } ?>
                    <li class="list-item <?php echo PageService::is_current_page([Page::STUDENT_BOOKINGS, Page::TEACHER_BOOKINGS]) ? 'active' : '' ?>">
                        <a class="list-link text-reset" href="<?php echo get_page_url(
                                                Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE) ? Page::STUDENT_BOOKINGS : Page::TEACHER_BOOKINGS
                                            ) ?>">
                            <?php echo __('Bookings') ?>
                        </a>
                    </li>
                    <li class="list-item <?php echo PageService::is_current_page([Page::STUDENT_LESSONS, Page::TEACHER_LESSONS]) ? 'active' : '' ?>">
                        <a class="list-link text-reset" href="<?php echo get_page_url(
                                                Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE) ? Page::STUDENT_LESSONS : Page::TEACHER_LESSONS
                                            ) ?>">
                            <?php echo __('Lesson Calendar') ?>
                        </a>
                    </li>
                    <li class="list-item <?php echo PageService::is_current_page([Page::STUDENT_SECURITY, Page::TEACHER_SECURITY]) ? 'active' : '' ?>">
                        <a class="list-link text-reset" href="<?php echo get_page_url(
                                                Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE) ? Page::STUDENT_SECURITY : Page::TEACHER_SECURITY
                                            ) ?>">
                            <?php echo __('Security') ?>
                        </a>
                    </li>
                    <li class="list-item <?php echo PageService::is_current_page([Page::STUDENT_MESSAGES, Page::TEACHER_MESSAGES]) ? 'active' : '' ?>">
                        <a class="list-link text-reset" href="<?php echo get_page_url(
                                                Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE) ? Page::STUDENT_MESSAGES : Page::TEACHER_MESSAGES
                                            ) ?>">
                            <?php echo __('Messages') ?>
                        </a>
                    </li>
                    <li class="list-item <?php echo PageService::is_current_page([Page::STUDENT_PAYMENTS, Page::TEACHER_WALLET]) ? 'active' : '' ?>">
                        <a class="list-link text-reset" href="<?php echo get_page_url(
                                                Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE) ? Page::STUDENT_PAYMENTS : Page::TEACHER_WALLET
                                            ) ?>">
                            <?php echo Auth::user()->is_teacher() ? __('Ledger') : __('Payments') ?>
                        </a>
                    </li>
                    <?php if (Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE)): ?>
                    <li class="list-item <?php echo PageService::is_current_page(Page::CREDIT_POINTS) ? 'active' : '' ?>">
                        <a class="list-link text-reset" href="<?php echo get_page_url(Page::CREDIT_POINTS) ?>">
                            <?php echo __('Credit Points') ?>
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php if (Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE)): ?>
                    <li class="list-item <?php echo PageService::is_current_page(Page::TOP_UP) ? 'active' : '' ?>">
                        <a class="list-link text-reset" href="<?php echo get_page_url(Page::TOP_UP) ?>">
                            <?php echo __('Top Up') ?>
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php if (Auth::has_role(User::TEACHER_ROLE)): ?>
                    <li class="list-item <?php echo PageService::is_current_page(Page::TEACHER_BANK_DETAILS) ? 'active' : '' ?>">
                        <a class="list-link text-reset" href="<?php echo get_page_url(Page::TEACHER_BANK_DETAILS) ?>">
                            <?php echo __('Bank Details') ?>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

    </div>

</div>