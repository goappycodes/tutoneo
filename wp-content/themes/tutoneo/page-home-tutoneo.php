<?php
/**
* Template Name: Home page
*
*/

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

?>
   <section data-jarallax data-speed=".8" class="pt-10 pb-11 py-md-14 overlay overlay-black overlay-60 jarallax" style="background-image: url(/wp-content/themes/tutoneo/ui/assets/img/covers/cover-4.jpg);">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-md-10 col-lg-8 text-center">
            
            <!-- Heading -->
            <h1 class="display-2 font-weight-bold text-white">
              What Do You Need?
            </h1>

            <!-- Text -->
            <p class="lead text-white-75 mb-0">
              We're here to help you better use Landkit. First, let's figure out if we have a solution in our documentation.
            </p>

          </div>
        </div> <!-- / .row -->
      </div> <!-- / .container -->
    </section>
    <div class="position-relative">
      <div class="shape shape-bottom shape-fluid-x svg-shim text-light">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 48h2880V0h-720C1442.5 52 720 0 720 0H0v48z" fill="currentColor"></path></svg>
      </div>
    </div>
<section class="p-bottom-150">
       <div class="container">
           <div class="cards">
               <div class="card-home">
      <div class="card-home__img">
     <img src="https://tutoneo.appycodes.com/wp-content/themes/tutoneo/core/resources/assets/img/home/teacher.png" class="img-fluid" />
         </div>
        
      <a href="#" class="gform_next_button">I AM A TEACHER</a>
   </div>
    <div class="card-home">
        <div class="card-home__img">
         <img src="https://tutoneo.appycodes.com/wp-content/themes/tutoneo/core/resources/assets/img/home/student.png" class="img-fluid" />
         </div>
        
      <a href="#" class="gform_next_button active">I AM A STUDENT</a>
   </div>
    <div class="card-home">
      <div class="card-home__img">
         <img src="https://tutoneo.appycodes.com/wp-content/themes/tutoneo/core/resources/assets/img/home/parent.png" class="img-fluid" />
      </div>
        
      <a href="#" class="gform_next_button">I AM A PARENENT</a>
   </div>
           </div>
         </div>
</section>
     
<?php get_footer(); ?>