<?php

  function profile_page_login() {

    if ( is_page( 1269 ) ) {
         add_filter('the_content', 'profile_page');
    }
}
add_action( 'template_redirect', 'profile_page_login' );

 function profile_page()
 {
$current_user = wp_get_current_user();
// echo "<pre>";print_r($current_user);exit();
// 
if (isset($_POST['update_profile'])) {


}
 	$message ='';
    if(isset($_GET['msg'])){
     if($_GET['msg']==1){
	   $message=get_option('l_success_msg'); 

	}
	} 
	//Form html
  $returner = "<p>".$message."</p>";
 $returner.='<form method="POST" enctype="multipart/form-data">';
  $returner.='<label for="user">Username</label><br>';
  $returner.='<input type="text" id="user" name="username"  value="' . $current_user->user_login . '"><br>';
  $returner.='<label for="fname">First name</label><br>';
  $returner.='<input type="text" id="fname" name="fname" value="' . $current_user->first_name . '"><br>';
  $returner.='<label for="lname">Last name</label><br>';
  $returner.='<input type="text" id="lname" name="lname" value="' . $current_user->last_name . '"><br>';
  $returner.='<label for="email">Email</label><br>';
  $returner.='<input type="text" id="email" name="email" value="' . $current_user->user_email . '"><br>';
  $returner.='<label for="pass">Password</label><br>';
  $returner.='<input type="password" id="password" name="password"><br>';
  $returner.='<label for="bio">Bio</label><br>';
  $returner.='<textarea id="bio" name="bio" rows="6" cols="50"></textarea><br>';
  $returner.='<input type="submit" id="update_profile" name="update_profile" value="Update"><br>';
  $returner.='</form>';
  return $returner;
}