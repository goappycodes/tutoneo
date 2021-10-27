<?php

use App\Models\Page;
use App\Models\User;
use App\Services\Auth;

?>


<?php if (!Auth::check()): ?>
    <a class="navbar-btn gform_previous_button lift ml-auto" href="<?php echo get_page_url(Page::SIGN_IN) ?>">
        <?php echo __('Sign In') ?>
    </a>
<?php else: ?>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="dropdown-toggle navbar-btn gform_next_button ml-auto" id="navbarAccount" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
                <?php echo __('Account') ?>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarAccount">
                <li class="dropdown-item">
                    <a href="<?php echo get_page_url(
                                    Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE) ? Page::STUDENT_DASHBOARD : Page::TEACHER_DASHBOARD
                                ) ?>" class="dropdown-link">
                        <?php echo __('Dashboard') ?>
                    </a>
                </li>
                <li class="dropdown-item">
                    <a href="<?php echo get_page_url(
                                    Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE) ? Page::STUDENT_PROFILE : Page::TEACHER_PROFILE
                                ) ?>" class="dropdown-link">
                        <?php echo __('Profile') ?>
                    </a>
                </li>
                <?php if (Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE)) { ?>
                    <li class="dropdown-item">
                        <a href="<?php echo get_page_url(Page::STUDENT_DOMINANT_MEMORY) ?>" class="dropdown-link">
                            <?php echo __('Dominant Memory') ?>
                        </a>
                    </li>
                <?php } ?>
                <li class="dropdown-item">
                    <a href="<?php echo get_page_url(
                                    Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE) ? Page::STUDENT_BOOKINGS : Page::TEACHER_BOOKINGS
                                ) ?>" class="dropdown-link">
                        <?php echo __('Bookings') ?>
                    </a>
                </li>
                <li class="dropdown-item">
                    <a href="<?php echo get_page_url(
                                    Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE) ? Page::STUDENT_LESSONS : Page::TEACHER_LESSONS
                                ) ?>" class="dropdown-link">
                        <?php echo __('Lesson Calendar') ?>
                    </a>
                </li>
                <li class="dropdown-item">
                    <a href="<?php echo get_page_url(
                                    Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE) ? Page::STUDENT_SECURITY : Page::TEACHER_SECURITY
                                ) ?>" class="dropdown-link">
                        <?php echo __('Security') ?>
                    </a>
                </li>
                <li class="dropdown-item">
                    <a href="<?php echo get_page_url(
                                    Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE) ? Page::STUDENT_MESSAGES : Page::TEACHER_MESSAGES
                                ) ?>" class="dropdown-link">
                        <?php echo __('Messages') ?>
                    </a>
                </li>
                <li class="dropdown-item">
                    <a href="<?php echo get_page_url(
                                    Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE) ? Page::STUDENT_PAYMENTS : Page::TEACHER_WALLET
                                ) ?>" class="dropdown-link">
                        <?php echo Auth::user()->is_teacher() ? __('Ledger') : __('Payments') ?>
                    </a>
                </li>
                <?php if (Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE)): ?>
                <li class="dropdown-item">
                    <a href="<?php echo get_page_url(Page::CREDIT_POINTS) ?>" class="dropdown-link">
                        <?php echo __('Credit Points') ?>
                    </a>
                </li>
                <?php endif; ?>
                
                <?php if (Auth::has_role(User::TEACHER_ROLE)): ?>
                <li class="dropdown-item">
                    <a href="<?php echo get_page_url(Page::TEACHER_BANK_DETAILS) ?>" class="dropdown-link">
                        <?php echo __('Bank Details') ?>
                    </a>
                </li>
                <?php endif; ?>
                
                <li class="dropdown-item">
                    <a class="dropdown-link" href="<?php echo wp_logout_url('/'); ?>">
                        <?php echo __('Log Out') ?>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
<?php endif; ?>