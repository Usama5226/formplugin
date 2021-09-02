<?php
  function custom_menu_page()
  {
   add_menu_page(
        'Admin menu',
        'Admin menu page',
        'manage_options',
        'menupage',
        'my_custom_menu_page',
        'dashicons-admin-users',
         90
    );
  }
add_action( 'admin_menu', 'custom_menu_page' );
  function my_custom_menu_page()
  {
  	if(isset($_POST['Update_msg'])){
    
     $s_success_msg = $_POST['s_success_msg'];
     $s_fail_msg = $_POST['s_fail_msg'];
     $l_success_msg = $_POST['l_success_msg'];
     $l_fail_msg = $_POST['l_fail_msg'];
     $login =$_POST['login_page'];
     $signup =$_POST['signup_page'];
     $profile =$_POST['profile_page'];
      update_option( 'login_page', $login);
      update_option( 'signup_page', $signup);
      update_option( 'profile_page', $profile); 
    
      update_option( 's_success_msg', $s_success_msg);
      update_option( 's_fail_msg', $s_fail_msg);
      update_option( 'l_success_msg', $l_success_msg);
      update_option( 'l_fail_msg', $l_fail_msg);
     // echo "<pre>";
     // print_r( $update);
     // exit();

}
  $returner = '<h2>Form confirmation message</h2>';
  $returner .= '<form method="POST" enctype="multipart/form-data">';
  $returner .= '<label for="s_success_msg">SignUp success message</label><br>';
  $returner .= '<input type="text" id="s_success_msg" name="s_success_msg" value="'.get_option('s_success_msg').'"><br>';
  $returner .= '<label for="s_fail_msg">SignUp failure Message</label><br>';
  $returner .= '<input type="text" id="s_fail_msg" name="s_fail_msg" value="'.get_option('s_fail_msg').'"><br>';
  $returner .= '<label for="l_success_msg">Login success message</label><br>';
  $returner .= '<input type="text" id="l_success_msg" name="l_success_msg" value="'.get_option('l_success_msg').'" ><br>';
  $returner .= '<label for="l_fail_msg">Login failure message</label><br>';
  $returner .= '<input type="text" id="l_fail_msg" name="l_fail_msg" value="'.get_option('l_fail_msg').'"><br><br>';

  $returner .= '<h2>Show on specific pages</h2>';
  $returner .= specific_pages('login page:', 'login_page');
  $returner .= specific_pages('signup page:', 'signup_page');
  $returner .= specific_pages('profile page:', 'profile_page');
  $returner .= '<input type="submit" name="Update_msg" value="Update_msg">';
  $returner .= '</form>';
  echo $returner;

  }

  function specific_pages( $field_label, $field_name)
  {
  


    $pages = get_pages();
    $option = '';
         foreach ( $pages as $page ):
      $option .= '<option value="' . $page->ID. '">';
      $option .= $page->post_title;
      $option .= '</option>';
      endforeach;
      $login_html = '<p>' .$field_label. '</p>';
      $login_html .= '<select name='.$field_name.'>'; 
      $login_html .= $option; 
      $login_html .= '</select><br><br>';
      return $login_html;  
  }