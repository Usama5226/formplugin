jQuery(document).ready(function($) {
  $(".request_field").keyup(function(){
      var request_value = $(this).prop('value');
      var request_for =  $(this).attr('name');
  $.ajax({
  url: myAjax.ajaxurl,
  type: "POST",
  data:  {action: "user_ajax_call", request_value:request_value, request_for:request_for }, 
   success: function(response) {
                 if (request_for === 'username') {
                 $(".username_msg").append(response);
                 }
                if (request_for === 'email') {
                 $(".email_msg").append(response);
                }
           },
}); 
});

 $(".signup").click(function(){
      var username = $("#username").prop('value');
      var email = $("#email").prop('value');
      var password = $(".password").prop('value');

      if (username == "" || username == null) {
      $(".username_msg").append("Usename field must be filled!");
      return false;
}  
      if (email == "" || email == null) {
      $(".email_msg").append("Email field must be filled!");
      return false;
}  
      if (password == "" || password == null) {
      $(".password_msg").append("Password field must be filled!");
      return false;
}


});
});