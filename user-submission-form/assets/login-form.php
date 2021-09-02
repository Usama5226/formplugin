<?php

  function login_page() {
    if ( is_page( get_option('login_page')) ) {
         add_filter('the_content', 'login_form');
    }
}
add_action( 'template_redirect', 'login_page' );

 add_action('template_redirect', 'custom_signon', 10);
 function custom_signon()
 {

 
global $wpdb;
    global $post;
    $slug = basename(get_permalink( get_the_ID()));
     $redirect_url = get_permalink( get_the_ID());
     $redirect_profile_page = get_home_url();
 
    if (isset($_POST['custom_login'])) {
     $user_data = array(
       'user_login'  => $_POST['username'], 
       'user_password' => $_POST['password'], 
   );
   $user = wp_signon( $user_data, false );

    if ( !is_wp_error( $user ) )
    {
        wp_redirect($redirect_profile_page."/profile-page/?msg=1");  
    } else {
        wp_redirect($redirect_url."?msg=2");

    }
    }

 }

  function login_form($content){
  	$message ='';
    if(isset($_GET['msg'])){
     if ($_GET['msg']==2) {
		$message=get_option('l_fail_msg');
		
	}
	} 
  $returner = "<p>".$message."</p>";
  $returner  .= '<form method="POST" enctype="multipart/form-data">';
  $returner .= '<label for="username">Username</label><br>';
  $returner .= '<input type="text" id="username" name="username"><br>';
  $returner .= '<label for="password">Password</label><br>';
  $returner .= '<input type="password" id="password" name="password"><br><br>';
  $returner .= '<input type="submit" name="custom_login" value="login">';
  $returner .= '</form>';

  return $content.$returner;

}