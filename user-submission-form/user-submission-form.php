<?php
/*
* Plugin Name: User Submission Form
* Author: Usama
*/
  function constants()
        {
            if ( !defined( 'USER_SUBMISSION_URL' ) ) {
                define( 'USER_SUBMISSION_URL', plugin_dir_url( __FILE__ ) );
            }
        }
  include plugin_dir_path( __FILE__ ) . '/assets/user-form.php';
  include plugin_dir_path( __FILE__ ) . '/assets/login-form.php';
  include plugin_dir_path( __FILE__ ) . '/assets/profile-page.php';
  include plugin_dir_path( __FILE__ ) . '/admin/admin-menu-page.php';

  add_action( 'show_user_profile', 'section_for_user', 999 );
  add_action( 'edit_user_profile', 'section_for_user', 999 );
  add_action( 'init', 'constants' );




  function section_for_user($user){
   $user_meta = get_user_meta( $user->ID,  $key = 'user_profile_pic');
   if (!empty($user_meta[0] ) ) {
   $attachment_url = wp_get_attachment_image_src( $user_meta[0] ); 
  }
  // echo"<pre>";print_r($attachment_url );exit();
?>

<h2>My custom section for user</h2>
<table class="form-table" role="presentation">

    <tr class="user-profile-picture">
  <th>Profile Picture</th>
  <td>
    <?php
    if (!empty($attachment_url[0] ) ) {      
    ?>
      <img alt='' src="<?php echo $attachment_url[0]?>"> 
<?php
}else{
  echo "No image found";
}
?>      
  <p class="description">
          </p>
  </td>
</tr>
      </table
<?php



}

