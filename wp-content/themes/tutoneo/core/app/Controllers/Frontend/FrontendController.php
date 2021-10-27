<?php

namespace App\Controllers\Frontend;

use App\Config\Config;
use App\Services\Auth;
use App\Controllers\Controller;

class FrontendController extends Controller
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        $this->load_classes();
    }

    public function load_classes()
    {
        QuestionnaireController::init();
        BookingController::init();
        SignInController::init(); 
        ForgotPasswordController::init();
        MakePaymentController::init();
        CapturePaymentSuccessController::init();
        TeacherRegistrationController::init();
        DashboardController::init();
        ProfileController::init();
        DominantMemoryController::init();
        BookingsController::init();
        TeacherLessonCalendarController::init();
        StudentLessonCalendarController::init();
        SecurityController::init();
        MessagesController::init();
        PaymentsController::init();
        TeacherWalletController::init();
        MessageThreadsController::init();
        CreditPointsController::init();
        TopUpController::init();
        TopUpPaymentController::init();
        TeacherBankDetailsController::init();
        GravityFormModifierController::init();
    }
    
    public function enqueue_scripts()
    {
        
        /* Libs CSS */
    
        wp_enqueue_style( 'tn-feather', get_stylesheet_directory_uri().'/ui/assets/fonts/Feather/feather.css' );
        wp_enqueue_style( 'tn-fancybox', get_stylesheet_directory_uri().'/ui/assets/libs/@fancyapps/fancybox/dist/jquery.fancybox.min.css' );
        wp_enqueue_style( 'tn-aos', get_stylesheet_directory_uri().'/ui/assets/libs/aos/dist/aos.css' );
        wp_enqueue_style( 'tn-choices', get_stylesheet_directory_uri().'/ui/assets/libs/choices.js/public/assets/styles/choices.min.css' );
        wp_enqueue_style( 'tn-flickity-fade', get_stylesheet_directory_uri().'/ui/assets/libs/flickity-fade/flickity-fade.css' );
        wp_enqueue_style( 'tn-flickity', get_stylesheet_directory_uri().'/ui/assets/libs/flickity/dist/flickity.min.css' );
        wp_enqueue_style( 'tn-jarallax', get_stylesheet_directory_uri().'/ui/assets/libs/jarallax/dist/jarallax.css' );
        wp_enqueue_style( 'tn-quill', get_stylesheet_directory_uri().'/ui/assets/libs/quill/dist/quill.core.css' );
    

        /* Theme CSS */
        wp_enqueue_style( 'tutoneo-css', get_stylesheet_directory_uri().'/ui/assets/css/theme.min.css' );
    
    
        // jQuery -->
        wp_deregister_script('jquery');
        wp_enqueue_script( 'jquery', get_stylesheet_directory_uri().'/ui/assets/libs/jquery/dist/jquery.min.js');
    
        // Libs JS -->
        
        wp_enqueue_script( 'tn-bootstrap', get_stylesheet_directory_uri().'/ui/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js', array(), '1.0.0.', true);
        wp_enqueue_script( 'tn-fancybox', get_stylesheet_directory_uri().'/ui/assets/libs/@fancyapps/fancybox/dist/jquery.fancybox.min.js', array(), '1.0.0.', true);
        wp_enqueue_script( 'tn-aos', get_stylesheet_directory_uri().'/ui/assets/libs/aos/dist/aos.js', array(), '1.0.0.', true);
        wp_enqueue_script( 'tn-choices', get_stylesheet_directory_uri().'/ui/assets/libs/choices.js/public/assets/scripts/choices.min.js', array(), '1.0.0.', true);
        wp_enqueue_script( 'tn-countUp', get_stylesheet_directory_uri().'/ui/assets/libs/countup.js/dist/countUp.min.js', array(), '1.0.0.', true);
        wp_enqueue_script( 'tn-dropzone', get_stylesheet_directory_uri().'/ui/assets/libs/dropzone/dist/min/dropzone.min.js', array(), '1.0.0.', true);
        wp_enqueue_script( 'tn-flickity', get_stylesheet_directory_uri().'/ui/assets/libs/flickity/dist/flickity.pkgd.min.js', array(), '1.0.0.', true);
        wp_enqueue_script( 'tn-flickity-fade', get_stylesheet_directory_uri().'/ui/assets/libs/flickity-fade/flickity-fade.js', array(), '1.0.0.', true);
        wp_enqueue_script( 'tn-imagesloaded', get_stylesheet_directory_uri().'/ui/assets/libs/imagesloaded/imagesloaded.pkgd.min.js', array(), '1.0.0.', true);
        wp_enqueue_script( 'tn-isotope', get_stylesheet_directory_uri().'/ui/assets/libs/isotope-layout/dist/isotope.pkgd.min.js', array(), '1.0.0.', true);
        wp_enqueue_script( 'tn-jarallax', get_stylesheet_directory_uri().'/ui/assets/libs/jarallax/dist/jarallax.min.js', array(), '1.0.0.', true);
        wp_enqueue_script( 'tn-jarallax-video', get_stylesheet_directory_uri().'/ui/assets/libs/jarallax/dist/jarallax-video.min.js', array(), '1.0.0.', true);
        wp_enqueue_script( 'tn-jarallax-element', get_stylesheet_directory_uri().'/ui/assets/libs/jarallax/dist/jarallax-element.min.js', array(), '1.0.0.', true);
        wp_enqueue_script( 'tn-quill', get_stylesheet_directory_uri().'/ui/assets/libs/quill/dist/quill.min.js', array(), '1.0.0.', true);
        wp_enqueue_script( 'tn-smooth-scroll', get_stylesheet_directory_uri().'/ui/assets/libs/smooth-scroll/dist/smooth-scroll.min.js', array(), '1.0.0.', true);
        wp_enqueue_script( 'tn-typed', get_stylesheet_directory_uri().'/ui/assets/libs/typed.js/lib/typed.min.js', array(), '1.0.0.', true);
    

        // Theme JS -->
        wp_enqueue_script( 'tn-theme', get_stylesheet_directory_uri().'/ui/assets/js/theme.min.js', array(), '1.0.0.', true);
        
        
        wp_enqueue_script(
            'stripe-js',
            'https://js.stripe.com/v3/'
        );

        wp_enqueue_style(
            'gravity-datepicker',
            Config::PUBLIC_CSS_DIR_URI . '/gravity-datepicker.min.css'
        );

        wp_enqueue_script(
            Config::PUBLIC_HANDLE,
            Config::PUBLIC_JS_DIR_URI . '/public.js',
            [Config::APP_HANDLE],
            time(),
            true
        );

        wp_enqueue_style(
            Config::PUBLIC_HANDLE,
            Config::PUBLIC_CSS_DIR_URI . '/public.css',
            [],
            time()
        );

        wp_localize_script(
            Config::PUBLIC_HANDLE,
            'public_obj',
            [
                'user_profile_pic' => Auth::check() ? Auth::user()->get_profile_pic() : null,
            ]
        );
        
        
        
        
    }
}
