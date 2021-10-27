// get formatted data time
function getFormattedDateTime(datetime, format = 'DD-MM-YYYY HH:mm') {
  var datetime = moment(datetime);
  return datetime.format(format);
}

// add user profile image to chat page
$(document).ready(function () {
  $('.fep-header-avatar').html('<img src="' + public_obj.user_profile_pic + '" alt="image">');
});


//FUNCTION NEXT ON OPTION SELECT (FORM STUDENT/PARENT)

$(document).bind('gform_page_loaded', function (event, form_id, current_page) {
  if ($('.gform_page_fields').length > 0) {
    $(".gfield_radio input[type=radio], .gfield_checkbox input[type=checkbox]").bind("click", function () {
      var radio_checkbox_count_for_the_page = $(this).parents('.gform_page').find(".gfield_radio, .gfield_checkbox").length;
      if (radio_checkbox_count_for_the_page == 1) {
        $(this).closest('.gform_page').find('.gform_page_footer .gform_next_button.button').click();
      }
    });
  }
});


//FUNCTION FOR CHECK ICON (FORM STUDENT/PARENT)

if ($('.gform_page_fields').length > 0) {
  $(document).ready(function () {
    $(".gform_body ul li label").click(function () {
      $(this).addClass("check-icon");
    });
  });
}

$(document).bind('gform_page_loaded', function (event, form_id, current_page) {
  if ($('.gform_page_fields').length > 0) {
    $(document).ready(function () {
      $(".gform_body ul li label").click(function () {
        $(this).addClass("check-icon");
      });
    });
  }
});


//FUNCTION FOR LABEL IMAGE (FORM STUDENT/PARENT)


//     if( $('.gform_page_fields').length > 0 ) {
//       	jQuery(document).ready(function(){

// 			$(".gfield_radio label, .gfield_checkbox  label").each(function(){
// 				var labeltext = $(this).text();

// 				var labelimage = "https:\/\/tutoneo.appycodes.com\/wp-content\/uploads\/2021\/01\/graduation.png";
// 				if (labelimage){
// 					$(this).html("<img src='"+labelimage+"' />"+labeltext);
// 				}
// 			});			
// 		});
//   }
// $(document).bind('gform_page_loaded', function(event, form_id, current_page){
//     if( $('.gform_page_fields').length > 0 ) {
// 	   	jQuery(document).ready(function(){

// 			$(".gfield_radio label, .gfield_checkbox  label").each(function(){
// 				var labeltext = $(this).text();

// 				var labelimage = "https:\/\/tutoneo.appycodes.com\/wp-content\/uploads\/2021\/01\/graduation.png";
// 				if (labelimage){
// 					$(this).html("<img src='"+labelimage+"' />"+labeltext);
// 				}
// 			});			
// 		});
//   }
// });





