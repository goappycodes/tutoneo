<?php

use App\Controllers\Frontend\ProfileController;
use App\Models\StudentUser;
use App\Models\User;
use App\Services\Auth;

?>
<form id="student-profile-form" enctype="multipart/form-data" class="ajax-form">
    <input type="hidden" name="action" value="<?php echo ProfileController::SAVE_STUDENT_PROFILE ?>">
    <div class="card card-bleed shadow-light-lg mb-6">
        <div class="card-header">

            <!-- Heading -->
            <h4 class="mb-0 font-weight-bold">
                <?php echo __('Profile') ?>
            </h4>

        </div>
        <div class="card-body">
          
                <div class="image-flex-profile">
                    <div class="avatar avatar-xxl profile-pic">
                        <img src="<?php echo Auth::user()->get_profile_pic() ?>" alt="..." class="avatar-img rounded-circle">
                    </div>
                    <input type="file" name="profile_pic" id="profile_pic" accept="image/*"> 
                </div>
          
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="first_name"><?php echo __('First Name') ?></label>
                    <input type="text" name="first_name" id="first_name" value="<?php echo Auth::user()->get_meta(StudentUser::FIRST_NAME) ?>" class="form-control">
                </div>
                <div class="col-md-6 form-group">
                    <label for="last_name"><?php echo __('Last Name') ?></label>
                    <input type="text" name="last_name" id="last_name" value="<?php echo Auth::user()->get_meta(StudentUser::LAST_NAME) ?>" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="email"><?php echo __('Email') ?></label>
                    <input type="email" readonly name="email" id="email" value="<?php echo Auth::user()->get_email() ?>" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="gender"><?php echo __('Gender') ?></label>
                    <select name="gender" id="gender" class="form-control">
                        <option <?php echo Auth::user()->get_meta(StudentUser::GENDER) == 'male' ? 'selected' : ''  ?> value="male"><?php echo __("Male") ?></option>
                        <option <?php echo Auth::user()->get_meta(StudentUser::GENDER) == 'female' ? 'selected' : ''  ?> value="female"><?php echo __("Female") ?></option>
                        <option <?php echo Auth::user()->get_meta(StudentUser::GENDER) == 'other' ? 'selected' : ''  ?> value="other"><?php echo __("Other") ?></option>
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label for="date_of_birth"><?php echo __('Date of Birth') ?></label>
                    <input type="text" name="date_of_birth" id="date_of_birth" value="<?php echo Auth::user()->get_meta(StudentUser::DATE_OF_BIRTH) ?>" class="form-control custom-datepicker">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="city"><?php echo __('City') ?></label>
                    <input type="text" name="city" id="city" value="<?php echo Auth::user()->get_meta(StudentUser::CITY) ?>" class="form-control">
                </div>
                <div class="col-md-6 form-group">
                    <label for="phone_no"><?php echo __('Phone No.') ?></label>
                    <input type="text" name="phone_no" id="phone_no" value="<?php echo Auth::user()->get_meta(StudentUser::PHONE) ?>" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="zoom_id"><?php echo __('Zoom Id') ?></label>
                    <input type="text" name="zoom_id" id="zoom_id" value="<?php echo Auth::user()->get_meta(StudentUser::ZOOM_ID) ?>" class="form-control">
                </div>
                <div class="col-md-6 form-group">
                    <label for="skype_id"><?php echo __('Skype Id') ?></label>
                    <input type="text" name="skype_id" id="skype_id" value="<?php echo Auth::user()->get_meta(StudentUser::SKYPE_ID) ?>" class="form-control">
                </div>
            </div>
            <?php if (Auth::has_role(User::STUDENT_ROLE)) { ?>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="parent_first_name"><?php echo __('Parent First Name') ?></label>
                        <input type="text" name="parent_first_name" id="parent_first_name" value="<?php echo Auth::user()->get_meta(StudentUser::PARENT_FIRST_NAME) ?>" class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="parent_last_name"><?php echo __('Parent Last Name') ?></label>
                        <input type="text" name="parent_last_name" id="parent_last_name" value="<?php echo Auth::user()->get_meta(StudentUser::PARENT_LAST_NAME) ?>" class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="parent_email"><?php echo __('Parent Email') ?></label>
                        <input type="text" name="parent_email" id="parent_email" value="<?php echo Auth::user()->get_meta(StudentUser::PARENT_EMAIL) ?>" class="form-control">
                    </div>
                </div>
            <?php } ?>
            
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="gform_next_button ">
                        <?php echo __('Submit') ?>
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>