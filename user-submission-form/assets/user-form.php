<?php
  
add_action("wp_ajax_user_ajax_call", "user_ajax_call");
add_action("wp_ajax_nopriv_user_ajax_call", "user_ajax_call");

function user_ajax_call() { 
   $validation_msg ='';
   if(isset($_REQUEST)) {
      $request_for= $_REQUEST['request_for'];
      $request_value = $_REQUEST['request_value'];
      if ($request_for === 'username') {
         if (username_exists( $request_value )) {
         $validation_msg = "Username already exists";
         }
      }
      if ($request_for === 'email') {
         if (email_exists( $request_value )) {
         $validation_msg = "Email already exists";
         }
 }
      echo $validation_msg; 
   }
  die();
}

 function validation()
 {
     wp_enqueue_script('validation', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js' ,array('jquery') );
    wp_enqueue_script('error_validation', USER_SUBMISSION_URL . 'js/validation.js' ,array('jquery','validation') );
   wp_localize_script( 'error_validation', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'error_validation' );

 }

 add_action( 'wp_enqueue_scripts', 'validation');
 function only_on_signup_page() {
    if ( is_page( get_option('signup_page') ) ) {
         add_filter('the_content', 'create_form');
    }
}
add_action( 'template_redirect', 'only_on_signup_page' );

// echo "<pre>";
// print_r($page);
// exit(); 
  function create_form($content){
   $error = false;
   $msg ='';
   
if ( isset($_POST['signup'])  ) {
   $userdata = array(
       'first_name'            => $_POST['fname'], 
       'last_name'             => $_POST['lname'],
       'nickname'              => $_POST['fname'],
       'user_login'            => $_POST['username'],
       'user_email'            => $_POST['email'],
       'user_pass'             => $_POST['password'],   
       'description'           => $_POST['bio'],   
   );



  //if condition if no error occurs.
  if (!$error) {
     $user_id = wp_insert_user( $userdata );
     //if condition if file exists
     if ($_FILES['profile_image']['name']) {
     $upload = wp_upload_bits( $_FILES['profile_image']["name"], null, file_get_contents( $_FILES['profile_image']["tmp_name"] ) );
      $filename    = $upload['file'];
      $wp_filetype = wp_check_filetype( $filename );
      $attachment = [
         'post_mime_type' => $wp_filetype['type'],
         'post_title'     =>  preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
         'post_content'   => '',
         'post_status'    => 'inherit',
      ];
      $attach_id = wp_insert_attachment( $attachment, $filename);
      require_once( ABSPATH . 'wp-admin/includes/image.php' );
      // generate attachment meta data
      $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
      // update attachment meta data
      wp_update_attachment_metadata( $attach_id, $attach_data );
      $umeta = update_user_meta( $user_id, 'user_profile_pic', $attach_id);
      $msg .= get_option('s_success_msg');
}
 }else{
   $msg .= '<br>'.get_option('s_fail_msg');
 } //form submit condition ends!
}//isset condition ends  

//Form html
$returner="<div class='validation'>".$msg."</div>";
 $returner.='<form name="signup_validation" id="signup_validation" method="POST"  enctype="multipart/form-data" >';
  $returner.='<label for="fname">First name</label><br>';
  $returner.='<input type="text" name="fname"><br>';
  $returner.='<label for="lname">Last name</label><br>';
  $returner.='<input type="text" name="lname"><br>';
  $returner.='<label for="user">Username*</label><br>';
  $returner.='<input type="text" class="request_field" id="username" name="username"><p class="username_msg"></p>';
  $returner.='<label for="email">Email*</label><br>';
  $returner.='<input type="text" class="request_field" id="email" name="email"><p class="email_msg"></p>';
  $returner.='<label for="pass">Password*</label><br>';
  $returner.='<input type="password"class="password" name="password"><p class="password_msg"></p>';
  $returner.='<label for="bio">Bio</label><br>';
  $returner.='<textarea name="bio" rows="6" cols="50"></textarea><br>';
  $returner.='<label for="image">Profile Picture</label><br>';
  $returner.='<input type="file" name="profile_image" accept=".png, .jpg, .jpeg"><br>';
  $returner.='<input type="submit" name="signup" class="signup" value="SignUp">';
  $returner.='</form>';
  return $returner.$content;
  //Form html ends

}//create_form ends.



