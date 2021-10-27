<?php

use App\Controllers\Frontend\ProfileController;
use App\Models\TeacherUser;
use App\Services\Auth;

$occupation = Auth::user()->get_meta(TeacherUser::OCCUPATION);
?>
<form id="teacher-profile-form" enctype="multipart/form-data" class="ajax-form">
    <input type="hidden" name="action" value="<?php echo ProfileController::SAVE_TEACHER_PROFILE ?>">
    <div class="card card-bleed shadow-light-lg mb-6">
        <div class="card-header">

            <!-- Heading -->
            <h4 class="mb-0 font-weight-bold">
                <?php echo __('Profile') ?>
            </h4>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 text-center form-group">
                    <div class="avatar avatar-xxl profile-pic">
                        <img src="<?php echo Auth::user()->get_profile_pic() ?>" alt="..." class="avatar-img rounded-circle">
                    </div>
                    <div class="clearfix"></div>
                    <input type="file" name="profile_pic" id="profile_pic" accept="image/*"> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="first_name"><?php echo __('First Name') ?></label>
                    <input type="text" name="first_name" id="first_name" value="<?php echo Auth::user()->get_meta(TeacherUser::FIRST_NAME) ?>" class="form-control">
                </div>
                <div class="col-md-6 form-group">
                    <label for="last_name"><?php echo __('Last Name') ?></label>
                    <input type="text" name="last_name" id="last_name" value="<?php echo Auth::user()->get_meta(TeacherUser::LAST_NAME) ?>" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="email"><?php echo __('Email') ?></label>
                    <input type="email" readonly name="email" id="email" value="<?php echo Auth::user()->get_email() ?>" class="form-control">
                </div>
                <div class="col-md-6 form-group">
                    <label for="gender"><?php echo __('Gender') ?></label>
                    <select name="gender" id="gender" class="form-control">
                        <option <?php echo Auth::user()->get_meta(TeacherUser::GENDER) == 'male' ? 'selected' : ''  ?> value="male"><?php echo __("Male") ?></option>
                        <option <?php echo Auth::user()->get_meta(TeacherUser::GENDER) == 'female' ? 'selected' : ''  ?> value="female"><?php echo __("Female") ?></option>
                        <option <?php echo Auth::user()->get_meta(TeacherUser::GENDER) == 'other' ? 'selected' : ''  ?> value="other"><?php echo __("Other") ?></option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="occupation"><?php echo __('Occupation') ?></label>
                    <select name="occupation" id="occupation" class="select2 form-control">
                        <option <?php echo $occupation == 'Student' ? 'selected' : '' ?> value="Student">Student</option>
                        <option <?php echo $occupation == 'Employee' ? 'selected' : '' ?> value="Employee">Employee</option>
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label for="subjects"><?php echo __('Subjects') ?></label>
                    <input type="text" name="subjects" id="subjects" value="<?php echo Auth::user()->get_meta(TeacherUser::SUBJECTS) ?>" class="form-control">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="gform_next_button">
                        <?php echo __('Submit') ?>
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>