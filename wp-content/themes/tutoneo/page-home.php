<?php
/**
* Template Name: Homepage
*
*/

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );

?>

<!-- WELCOME
================================================== -->
<section data-jarallax data-speed=".8" class="pt-12 pb-12 pt-md-15 pb-md-14 overlay-gradient-blue" style="background: url(<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/covers/cover-3.jpg)">
    
  <div class="container">
    <div class="row align-items-center">
      <div class="col-12 col-md-8 col-lg-6">

        <!-- Heading -->
        <h1 class="display-3 font-weight-bold text-white" id="welcomeHeadingSource">
        Get courses online<br />
          <span class="text-dark-blue" data-toggle="typed" data-options='{"strings": ["Explore as student", "Explore as parent", "Explore as teacher" ]}'></span>
        </h1>


        <!-- Text -->
        <p class="font-size-lg text-white-80 mb-6">
          We help place the world's top tech talent at the some of the greatest companies in the world.
        </p>
              
              
        <div class="position-absolute">
          <a class="btn gform_next_button lift" data-toggle="smooth-scroll" href="#i-am-a-atudent">
             Get started  <i class="fe fe-arrow-down"></i>
          </a>
        </div>
        

      </div>
    </div> 
  </div> 
</section>




  <section class="mt-n8 pb-10 bg-white-smoke" id="i-am-a-atudent">
      <div class="container">
        <div class="row">
          <div class="col-12 col-md-4" data-aos="fade-up">
            
            <div class="card shadow-light-lg mb-6 mb-md-0 lift lift-lg">
              
             <div class=" img-overlay"></div>
             <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/photos/photo-4.jpg" alt="..." class="card-img-top">
            
              <div class="position-relative">
                <div class="shape shape-bottom shape-fluid-x svg-shim text-white">
                  <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 48h2880V0h-720C1442.5 52 720 0 720 0H0v48z" fill="currentColor"/></svg>
                </div>
              </div>

             
              <div class="card-body position-relative">

                <h3>
                  I am a student
                </h3>

              
                <p class="text-muted">
                  Open seating is available weekdays from 7am - 7pm and weekends from 9am - 5pm.
                </p>

              <a class="btn gform_next_button" data-toggle="smooth-scroll" href="https://tutoneo.appycodes.com/home/student-questionnaire/">
                   Get started
             </a>
                <!--<a href="https://tutoneo.appycodes.com/home/student-questionnaire/" class="font-weight-bold text-decoration-none">-->
                <!--    Let's Start <i class="fe fe-arrow-right ml-3"></i>-->
                <!--</a>-->

              </div>

            </div>

          </div>
         
          <div class="col-12 col-md-4" data-aos="fade-up">
            
            <div class="card shadow-light-lg mb-6 mb-md-0 lift lift-lg">
              
             <div class=" img-overlay"></div>
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/photos/photo-6.jpg" alt="..." class="card-img-top">

             
              <div class="position-relative">
                <div class="shape shape-bottom shape-fluid-x svg-shim text-white">
                  <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 48h2880V0h-720C1442.5 52 720 0 720 0H0v48z" fill="currentColor"/></svg>
                </div>
              </div>

             
              <div class="card-body position-relative">

                <h3>
                  I am a parent
                </h3>

              
                <p class="text-muted">
                  Open seating is available weekdays from 7am - 7pm and weekends from 9am - 5pm.
                </p>

               <a class="btn gform_next_button" data-toggle="smooth-scroll" href="https://tutoneo.appycodes.com/home/parent-questionnaire/">
                   Get started
               </a>
                <!--<a href="https://tutoneo.appycodes.com/home/parent-questionnaire/" class="font-weight-bold text-decoration-none">-->
                <!--    Let's Start <i class="fe fe-arrow-right ml-3"></i>-->
                <!--</a>-->

              </div>

            </div>

          </div>
           <div class="col-12 col-md-4" data-aos="fade-up">
            
            <div class="card shadow-light-lg mb-6 mb-md-0 lift lift-lg">
              
             <div class=" img-overlay"></div>
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/photos/photo-5.jpg" alt="..." class="card-img-top">

             
              <div class="position-relative">
                <div class="shape shape-bottom shape-fluid-x svg-shim text-white">
                  <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 48h2880V0h-720C1442.5 52 720 0 720 0H0v48z" fill="currentColor"/></svg>
                </div>
              </div>

             
              <div class="card-body position-relative">

                <h3>
                  I am a teacher
                </h3>

              
                <p class="text-muted">
                  Open seating is available weekdays from 7am - 7pm and weekends from 9am - 5pm.
                </p>

              <a class="btn gform_next_button" data-toggle="smooth-scroll" href="https://tutoneo.appycodes.com/home/teacher-registration/">
                   Get started
               </a>
                <!--<a href="https://tutoneo.appycodes.com/home/teacher-registration/" class="font-weight-bold text-decoration-none">-->
                <!--    Let's Start <i class="fe fe-arrow-right ml-3"></i>-->
                <!--</a>-->

              </div>

            </div>

          </div>
          
        </div> <!-- / .row -->
      </div> <!-- / .container -->
    </section>
    
    <!-- PROCESS
================================================== -->
<section class="pt-8  pt-md-11">
  <div class="container">
    <div class="row align-items-center justify-content-between">
      <div class="col-12 col-md-6">

        <!-- Preheading -->
        <h6 class="text-uppercase text-primary font-weight-bold">
          Process
        </h6>

        <!-- Heading -->
        <h2>
          Our process to find you a new job is fast and you can do it from home.
        </h2>

        <!-- Text -->
        <p class="lead text-muted mb-6 mb-md-0">
          We keep everything as simple as possible by standardizing the application process for all jobs.
        </p>

      </div>
      <div class="col-12 col-md-6 col-xl-5">

        <div class="row no-gutters">
          <div class="col-4">

            <!-- Image -->
            <div class="w-150 mt-9 p-1 bg-white shadow-lg" data-aos="fade-up" data-aos-delay="100">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/photos/photo-13.jpg" class="img-fluid" alt="...">
            </div>

          </div>
          <div class="col-4">

            <!-- Image -->
            <div class="w-150 p-1 bg-white shadow-lg" data-aos="fade-up">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/photos/photo-14.jpg" class="img-fluid" alt="...">
            </div>

          </div>
          <div class="col-4 position-relative">

            <!-- Image -->
            <div class="w-150 mt-11 float-right p-1 bg-white shadow-lg" data-aos="fade-up" data-aos-delay="150">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/photos/photo-15.jpg" class="img-fluid" alt="...">
            </div>

          </div>
        </div> <!-- / .row -->

      </div>
    </div> <!-- / .row -->
  </div> <!-- / .container -->
</section>

<!-- STEPS
================================================== -->
<section class="pt-8 pt-md-10 pb-md-5">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-4">
        <div class="row">
          <div class="col-auto col-md-12">

            <!-- Step -->
            <div class="row no-gutters align-items-center mb-md-5">
              <div class="col-auto">

                <a href="#!" class="btn btn-sm btn-rounded-circle btn-gray-400 disabled opacity-1">
                  <span>1</span>
                </a>

              </div>
              <div class="col">

                <hr class="d-none d-md-block mr-n7">

              </div>
            </div> <!-- / .row -->

          </div>
          <div class="col col-md-12 ml-n5 ml-md-0">

            <!-- Heading -->
            <h3>
              Complete your application.
            </h3>

            <!-- Text -->
            <p class="text-muted mb-6 mb-md-0">
              Fill out our standardized application on our platform. Most applicants finish in under an hour.
            </p>

          </div>
        </div> <!-- / .row -->
      </div>
      <div class="col-12 col-md-4">
        <div class="row">
          <div class="col-auto col-md-12">

            <!-- Step -->
            <div class="row no-gutters align-items-center mb-md-5">
              <div class="col-auto">

                <a href="#!" class="btn btn-sm btn-rounded-circle btn-gray-400 disabled opacity-1">
                  <span>2</span>
                </a>

              </div>
              <div class="col">

                <hr class="d-none d-md-block mr-n7">

              </div>
            </div> <!-- / .row -->

          </div>
          <div class="col col-md-12 ml-n5 ml-md-0">

            <!-- Heading -->
            <h3>
              Select companies.
            </h3>

            <!-- Text -->
            <p class="text-muted mb-6 mb-md-0">
              We'll immediately match you with any relevant openings and you get to pick which ones you're interested in.
            </p>

          </div>
        </div> <!-- / .row -->
      </div>
      <div class="col-12 col-md-4">
        <div class="row">
          <div class="col-auto col-md-12">

            <!-- Step -->
            <div class="row no-gutters align-items-center mb-md-5">
              <div class="col-auto">

                <a href="#!" class="btn btn-sm btn-rounded-circle btn-gray-400 disabled opacity-1">
                  <span>3</span>
                </a>

              </div>
            </div> <!-- / .row -->

          </div>
          <div class="col col-md-12 ml-n5 ml-md-0">

            <!-- Heading -->
            <h3>
              Choose your offer.
            </h3>

            <!-- Text -->
            <p class="text-muted mb-0">
              After 3 days all of your offers will arrive and you will have another 7 days to select your new company.
            </p>

          </div>
        </div> <!-- / .row -->
      </div>
    </div> <!-- / .row -->
   
  </div> <!-- / .container -->
</section>
    
    
    <section>
  <div class="container py-8 pt-md-11 pb-md-9">
    <div class="row">
      <div class="col-12 col-md-10 col-lg-8">

        <!-- Preheading -->
        <h6 class="text-uppercase text-primary">
          Placement rates
        </h6>

        <!-- Heading -->
        <h2 class="mb-6 mb-md-8">
          Landkit is the leading job placement site with the highest rate of success of any tech job board.
        </h2>

        <!-- Stats -->
        <div class="placement-rates">
          <div>
            <h3 class="mb-0">
              <span data-toggle="countup" data-from="0" data-to="74" data-aos data-aos-id="countup:in">0</span>k
            </h3>
            <p class="text-gray-700 mb-0">
              Placements
            </p>
          </div>
          <div>
            <h3 class="mb-0">
              <span data-toggle="countup" data-from="0" data-to="124" data-aos data-aos-id="countup:in">0</span>k
            </h3>
            <p class="text-gray-700 mb-0">
              Positions
            </p>
          </div>
          <div>
            <h3 class="mb-0">
              <span data-toggle="countup" data-from="0.0" data-to="1.9" data-decimals="1" data-aos data-aos-id="countup:in">0.0</span>k
            </h3>
            <p class="text-gray-700 mb-0">
              Partnerships
            </p>
          </div>
        </div>

      </div>
    </div> <!-- / .row -->
  </div> <!-- / .container -->
</section>


<section data-jarallax data-speed=".8" class="py-14 py-lg-16 jarallax  bg-white-smoke" style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/covers/cover-7.jpg);">

   
  <div class="shape shape-top shape-fluid-x svg-shim text-white">
    <svg viewBox="0 0 2880 250" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h2880v125h-720L720 250H0V0z" fill="currentColor"/></svg>
  </div>

  
  <div class="shape shape-bottom shape-fluid-x svg-shim text-white">
    <svg viewBox="0 0 2880 250" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M720 125L2160 0h720v250H0V125h720z" fill="currentColor"/></svg>
  </div>

</section>
    

<section class="pt-7 pt-md-10">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-12 col-md">
                <h3 class="mb-0">
                    Latest Blogs
                </h3>
                <p class="mb-0 text-muted">
                    Here’s what we've been up to recently.
                </p>
            </div>
            <div class="col-12 col-md-auto">
                <a href="#!" class="btn btn-sm btn-outline-gray-300 d-none d-md-inline">
                    View all
                </a>
            </div>
        </div>
        
        
        <?php 
// the query
$wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>3)); ?>
 
<?php if ( $wpb_all_query->have_posts() ) : ?>
 
 <div class="row">
      <?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
    <div class="col-12 col-md-6 col-lg-4 d-flex">
                <div class="card mb-6 mb-lg-6 shadow-light-lg lift lift-lg custom-img">
                    <a class="card-img-top" href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('full'); ?>
                      
                    
                        <div class="position-relative">
                            <div class="shape shape-bottom shape-fluid-x svg-shim text-white">
                                <svg viewBox="0 0 2880 480" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2160 0C1440 240 720 240 720 240H0v240h2880V0h-720z" fill="currentColor" />
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a class="card-body" href="<?php the_permalink(); ?>">
                        <h3>
                            <?php the_title(); ?>
                        </h3>
                       
                        <?php echo wp_trim_words( get_the_content(), 15 ); ?>
                    </a>
                 
                    <a class="card-meta mt-auto" href="#!">
                        <hr class="card-meta-divider">
                        <!--<div class="avatar avatar-sm mr-2">-->
                        <!--    <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/avatars/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">-->
                        <!--</div>-->
                        <h6 class="text-uppercase text-muted mr-2 mb-0">
                            <?php the_author(); ?>
                        </h6>
                        <p class="h6 text-uppercase text-muted mb-0 ml-auto">
                            <time> <?php the_date(); ?></time>
                        </p>
                    </a>
                </div>
            </div>
            <?php endwhile; ?>
            
  
          
          </div>
         <?php wp_reset_postdata(); ?>
        
           
        
 
<?php else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
        
      
          
          
          
    </div>
</section>




<section class="">
  <div class="container">
       <hr/>
    <div class="row align-items-center pt-5 pb-8">
      <div class="col-12 col-md">

        <!-- Heading -->
        <h3 class="mb-1">
          Apply in 15 minutes
        </h3>

        <!-- Text -->
        <p class="font-size-lg text-muted mb-6 mb-md-0">
          Get your dream job without the hassle.
        </p>

      </div>
      <div class="col-12 col-md-auto">

        <a class="btn gform_next_button lift mr-1 pd-lg" data-toggle="smooth-scroll" href="#">
            Learn more 
          </a>
        <!--<a href="#!" class="btn btn-primary-soft mr-1 lift">-->
        <!--  Learn more-->
        <!--</a>-->

        <a href="#!" class="btn btn-primary lift">
          Get started
        </a>

      </div>
    </div> 
  </div>
</section>


<?php get_footer(); ?>